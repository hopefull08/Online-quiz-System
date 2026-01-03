let currentIndex = 0;
let score = 0;
let hasAnswered = false;

document.addEventListener("DOMContentLoaded", () => {
    showQuestion();
    document.getElementById("continueBtn").addEventListener("click", nextQuestion);
});


function showQuestion() {
    let container = document.getElementById("quiz-container");
    container.innerHTML = "";

    let q = questions[currentIndex];
    let questionDiv = document.createElement("div");
    questionDiv.className = "question";

let p = document.createElement("p");
// Add 1 because currentIndex starts at 0
p.textContent = `${currentIndex + 1}. ${q.question_text}`;
questionDiv.appendChild(p);


    ["A","B","C"].forEach(opt => {
        if (q["option_" + opt.toLowerCase()]) {
            let label = document.createElement("label");
            label.textContent = q["option_" + opt.toLowerCase()];
            label.style.display = "block";

            let input = document.createElement("input");
            input.type = "radio";
            input.name = "answer";
            input.value = opt;

            input.onclick = () => {
                hasAnswered = true;
            // Disable all radios for this question once one is chosen
                const allRadios = document.getElementsByName("answer");
                allRadios.forEach(r => {
                    r.disabled = true;
                    // also grey out the label text for each disabled radio
                    if (r !== input) {
                        r.parentElement.style.color = "grey";
                    }
                    });

                if (input.value === q.correct_answer) {
                    label.style.color = "green";
                    score++;
                } else {
                    label.style.color = "red";
                }
                document.getElementById("continueBtn").style.display = "inline-block";
            };


            label.prepend(input);
            questionDiv.appendChild(label);
        }
    });

    container.appendChild(questionDiv);
}

function nextQuestion() {
    currentIndex++;
    document.getElementById("continueBtn").style.display = "none";

    if (currentIndex < questions.length) {
        showQuestion();
    } else {
        // Finished
        let scoreText = document.getElementById("scoreText");
        scoreText.textContent = `You answered ${score} / ${questions.length} correctly.`;
        document.getElementById("resultOverlay").style.display = "block";
    }
}

function closeOverlay() {
  hasAnswered = false;
  window.location.replace("qlist.php?course_id=" + courseId);
}

window.addEventListener("beforeunload", (event) => {
    if (hasAnswered) {
        event.preventDefault();
        // Chrome requires returnValue to be set
        event.returnValue = "Your answers will be reset and you will start again. Are you sure?";
    }
});






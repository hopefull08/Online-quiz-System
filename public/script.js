let currentIndex = 0;
let score = 0;

window.onload = () => {
    showQuestion();
    document.getElementById("continueBtn").addEventListener("click", nextQuestion);
};

function showQuestion() {
    let container = document.getElementById("quiz-container");
    container.innerHTML = "";

    let q = questions[currentIndex];
    let questionDiv = document.createElement("div");
    questionDiv.className = "question";

    let p = document.createElement("p");
    p.textContent = q.question_text;
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
        scoreText.textContent = `You answered ${score} out of ${questions.length} correctly.`;
        document.getElementById("resultOverlay").style.display = "block";
    }
}

function closeOverlay() {
    document.getElementById("resultOverlay").style.display = "none";
}

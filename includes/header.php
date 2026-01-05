<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <button id="toggleDarkMode" class="btnt"><i class="fas fa-moon"></i></button>

    <script>
document.addEventListener("DOMContentLoaded", () => {
    const toggleBtn = document.getElementById("toggleDarkMode");
    const icon = toggleBtn.querySelector("i");

    function applyTheme(theme) {
        if (theme === "dark") {
            document.body.classList.add("dark-mode");
            icon.classList.remove("fa-moon");
            icon.classList.add("fa-sun");
        } else {
            document.body.classList.remove("dark-mode");
            icon.classList.remove("fa-sun");
            icon.classList.add("fa-moon");
        }
        localStorage.setItem("theme", theme);
    }

    if (toggleBtn) {
        toggleBtn.addEventListener("click", () => {
            const newTheme = document.body.classList.contains("dark-mode") ? "light" : "dark";
            applyTheme(newTheme);
        });
    }

    // Apply saved theme on load
    applyTheme(localStorage.getItem("theme") || "light");
});
</script>
</body>
</html>


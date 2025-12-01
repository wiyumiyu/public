<script>
// ===================================================
// MODO CLARO / OSCURO — COMPATIBLE CON TU TOPBAR REAL
// ===================================================

document.addEventListener("DOMContentLoaded", function () {

    const container = document.getElementById("toggleMode");
    const lightBtn  = document.getElementById("lightModeBtn");
    const darkBtn   = document.getElementById("darkModeBtn");

    if (!container || !lightBtn || !darkBtn) return;

    // 1. Aplicar tema guardado
    let saved = localStorage.getItem("theme") || "light";
    document.documentElement.setAttribute("data-bs-theme", saved);

    // Marcar el botón activo
    if (saved === "dark") {
        darkBtn.classList.add("active");
        lightBtn.classList.remove("active");
    } else {
        lightBtn.classList.add("active");
        darkBtn.classList.remove("active");
    }

    // 2. Activar modo claro
    lightBtn.addEventListener("click", function () {
        document.documentElement.setAttribute("data-bs-theme", "light");
        localStorage.setItem("theme", "light");

        lightBtn.classList.add("active");
        darkBtn.classList.remove("active");
    });

    // 3. Activar modo oscuro
    darkBtn.addEventListener("click", function () {
        document.documentElement.setAttribute("data-bs-theme", "dark");
        localStorage.setItem("theme", "dark");

        darkBtn.classList.add("active");
        lightBtn.classList.remove("active");
    });
});
</script>

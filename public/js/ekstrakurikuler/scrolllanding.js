// Auto scroll setiap 3 detik
document.addEventListener("DOMContentLoaded", () => {
    const slider = document.getElementById("ekskul-slider");
    let scrollAmount = 0;
    const scrollStep = 320; // lebar 1 card
    const delay = 3000;

    setInterval(() => {
        if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth) {
            // balik ke awal kalau sudah mentok kanan
            slider.scrollTo({ left: 0, behavior: "smooth" });
            scrollAmount = 0;
        } else {
            scrollAmount += scrollStep;
            slider.scrollTo({ left: scrollAmount, behavior: "smooth" });
        }
    }, delay);
});
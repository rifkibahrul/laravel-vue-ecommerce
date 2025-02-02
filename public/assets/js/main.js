// Scroll reveal animations
const sr = ScrollReveal({
    origin: "bottom",
    distance: "60px",
    duration: 3000,
    delay: 400,
});

// Hero
sr.reveal(".hero__text", { origin: "top" });

// Services
sr.reveal(".services__service", { distance: "100px", interval: 100, delay: 100 });

// Latest Product
sr.reveal(".latest__text", { origin: "top" });
sr.reveal(".latest__product", { origin:'left', distance: "100px", interval: 100 });

// View Product
sr.reveal(".view__bg", { delay: 800 });
sr.reveal(".view__text");

// Footer
sr.reveal(".footer__item", { distance: "100px", interval: 100 });
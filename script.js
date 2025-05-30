document.addEventListener("DOMContentLoaded", () => {
  const valueDisplays = document.querySelectorAll(".count");

  const startCounting = (valueDisplay) => {
    const endValue = parseInt(valueDisplay.getAttribute("data-target"));
    const duration = 2000; // durasi animasi dalam ms (2 detik)
    const startTime = performance.now();

    const update = (currentTime) => {
      const elapsed = currentTime - startTime;
      let progress = Math.min(elapsed / duration, 1);
      let currentValue = Math.floor(progress * endValue);

      if (currentValue >= 1000) {
        let displayVal = (currentValue / 1000).toFixed(currentValue % 1000 === 0 ? 0 : 1);
        valueDisplay.textContent = displayVal + "K+";
      } else {
        valueDisplay.textContent = currentValue + "+";
      }

      if (progress < 1) {
        requestAnimationFrame(update);
      } else {
        // Pastikan nilai akhir ditampilkan dengan benar
        if (endValue >= 1000) {
          let displayVal = (endValue / 1000).toFixed(endValue % 1000 === 0 ? 0 : 1);
          valueDisplay.textContent = displayVal + "K+";
        } else {
          valueDisplay.textContent = endValue + "+";
        }
      }
    };

    requestAnimationFrame(update);
  };

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const target = entry.target;
          if (!target.classList.contains("counted")) {
            startCounting(target);
            target.classList.add("counted");
          }
        }
      });
    },
    { threshold: 0.65 }
  );

  valueDisplays.forEach((valueDisplay) => {
    observer.observe(valueDisplay);
  });
});


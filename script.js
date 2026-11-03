document.addEventListener("DOMContentLoaded", function () {

  const images = document.querySelectorAll("img");
  const promises = [];

  images.forEach((image) => {
    // console.log(image);
    if (image.complete) {
      // console.log('Image already loaded');
      promises.push(Promise.resolve());
    } else {
      promises.push(
        new Promise((resolve) => {
          // console.log('Image not loaded yet');
          image.onload = resolve;
          image.onerror = resolve;
        })
      );
    }
  });

  Promise.all(promises).then(() => {
    console.log("All images loaded.");
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("in-view");
          // console.log('Element in view:', entry.target);
        }
      });
    });

    const elements = document.querySelectorAll(".animate");
    elements.forEach((element) => {
      observer.observe(element);
      // console.log('Observing element:', element);
    });

  });


  document.querySelectorAll('img[src="./img/globe.svg"]').forEach((button) => {
		
    button.addEventListener("click", () => {
      const elements = document.querySelectorAll("[data-fr][data-en]");
      const currentLanguage = document.documentElement.lang || "en"; // Default to 'en'
      const newLanguage = currentLanguage === "en" ? "fr" : "en";
      document.documentElement.lang = newLanguage; // Update the language attribute
      document.querySelector("body").classList.add("language-switch");
      document.querySelector("body").classList.remove("visible");
      elements.forEach((element) => {
        // Add fade-out effect
        element.classList.remove("visible");
        setTimeout(() => {
          // Update text after fade-out
          element.innerHTML = element.getAttribute(`data-${newLanguage}`);
          // Add fade-in effect
          // element.classList.add('visible');
        }, 500); // Match the CSS transition duration
      });
      setTimeout(() => {
        // Update text after fade-out
        document.querySelector("body").classList.add("visible");
      }, 500); // Match the CSS transition duration
    });
  });


  const isScrollBarVisible = document.body.clientHeight > window.innerHeight;
  console.log("isScrollBarVisible:", isScrollBarVisible, "(", document.body.clientHeight, ">", window.innerHeight, ")");
  if (!isScrollBarVisible) document.body.style.marginRight = "10px";
});



window.addEventListener("scroll", function () {
  const scrollYValue = window.scrollY;
  modifyHeaderBar(scrollYValue);
  checkOpacity();
});



window.addEventListener("load", function () {
  window.scrollTo({
    top: 0,
    behavior: "instant",
  });
});



function checkOpacity() {
  const elements = document.querySelectorAll(".animate");
  elements.forEach((element) => {
    const opacity = window.getComputedStyle(element).opacity;
    // console.log(element, "=>", opacity);
    if (opacity == "1") {
      element.classList.add("viewed");
    }
  });
}



function modifyHeaderBar(scrollYValue) {
  // console.log(scrollYValue);
  const headerBar = document.querySelector("header");
  const scrollThreshold = 20;
  const goUpButton = document.querySelector("button#go-up");
  // console.log(goUpButton);
  if (scrollYValue > scrollThreshold) {
    headerBar.classList.add("header--scrolled");
    goUpButton.classList.add("show");
  } else {
    headerBar.classList.remove("header--scrolled");
    goUpButton.classList.remove("show");
  }
}


// Add a fade-out effect when navigating to another page
document.querySelectorAll("a").forEach((link) => {
  link.addEventListener("click", (event) => {
    const href = link.getAttribute("href");
    if (href && !href.startsWith("#")) {
      event.preventDefault();
      document.querySelector("main").classList.add("fade-out");
      document.querySelector("header").classList.remove("header--scrolled");
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
      document.body.style.overflow = "hidden";
      document.body.style.marginRight = "10px";
      setTimeout(async () => {
        // await fetch(href).then(async (response) => {
        //     const responseHTML = await response.text()
        //     console.log(responseHTML);
        //     window.history.pushState({}, '', href);
        //     document.querySelector('html').innerHTML = new DOMParser().parseFromString(responseHTML, 'text/html').querySelector('html').innerHTML;
        // });
        window.location.href = href;
      }, 500); // Match the duration of the fade-out animation
    }
  });
});



window.onload = () => {
  document.querySelector("main").classList.remove("fade-in");
};



document.querySelectorAll(".animate").forEach((element) => {
  console.log(1);
  element.addEventListener("animationend", (event) => {
    console.log("=> animation finished");
    event.target.classList.add("viewed");
  });
});


function goUp() {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}

// Google Analytics' bootstrap, kept out of the pages so they need no inline script. The tag id is the script
// element's data-google-tag.
window.dataLayer = window.dataLayer || [];
function gtag() {
  dataLayer.push(arguments);
}
gtag("js", new Date());
gtag("config", document.currentScript.dataset.googleTag);

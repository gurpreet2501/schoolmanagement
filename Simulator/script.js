chrome.runtime.onMessageExternal.addListener(
  function (request, sender, sendResponse) {
    sendResponse(Math.floor(Math.random()*10000));
  }
);
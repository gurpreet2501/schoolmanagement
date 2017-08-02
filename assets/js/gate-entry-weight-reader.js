$(function(){
  setInterval(function(){
    chrome.runtime.sendMessage(
      env('CHROME_WEIGHT_APP_ID',''),
      { data: "data to pass to the chrome app" },  
      function (response){
        if(window.GATE_ENTRY)
          window.GATE_ENTRY.comWeight = response;
      }
    );
  },100);
});
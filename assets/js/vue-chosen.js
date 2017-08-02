Vue.directive('select2', {
  //When the bound element is inserted into the DOM...
  bind: function (el,binding) {
    /*$(el).chosen().change(function(){
      binding.value = el.value;
    });*/
  },

  inserted: function (el, binding) {
    console.log(binding.value)
    $(el).chosen().change(function(){
      binding.value = el.value;
    });
  },
})
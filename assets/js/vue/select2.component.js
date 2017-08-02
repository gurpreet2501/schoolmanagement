Vue.component('select2', {
  props: ['options','text','id','value'],
  template: '<select><slot></slot></select>',
  mounted: function () {
    var vm = this
    var composedOptions = this.composeOptions(this.options);
    $(this.$el)
      // init select2
      .select2({ data: composedOptions })
      .val(this.value)
      .trigger('change')
      // emit event on change.
      .on('change', function () {
        vm.$emit('input', this.value)
      })
  },
  methods: {
    composeOptions: function(options){
      var vm = this
      var composedOptions = [];
      $.each(options, function(key, item){
        composedOptions.push({
          id: item[vm.id],
          text: item[vm.text]
        });
      });
      return composedOptions;
    }
  },
  watch: {
    value: function (value) {
      // update value
      $(this.$el).val(value).trigger('change');
    },
    options: function (options) {
      // update options
      $(this.$el).select2({ data: this.composeOptions(this.options) })
    }
  },
  destroyed: function () {
    $(this.$el).off().select2('destroy');
  }
})
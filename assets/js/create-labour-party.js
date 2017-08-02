jQuery(function($){
  
  window.CREATE_LABOUR_PARTY = new Vue({
  el: '#create_labour_party',
  data: {
    cat_id: v('selected_labour_job_categories'),
    jobTypeRates: v('labour_party_job_type_rates')
  },  
  computed: {
  	jobTypes: function(){
    	var types = [];	
      var arr = [];
      filterredTypes = [];
      var category_ids = this.cat_id;

    	$.each(v('labour_job_types'), function( index, jobType ){
         flag = false;
         
         if(jobType.labour_job_category_id ==null)
            jobType.labour_job_category_id = 0;

          jobType.labour_job_category_id = jobType.labour_job_category_id+'';

           var flag = category_ids.find(function matchCatId(element) {
             if(element == jobType.labour_job_category_id)
               return true;
          });

          if(flag)
            filterredTypes.push(jobType); 
  	  });  

  	  return filterredTypes;
  	     
  }

  
  },
  methods:{
    getJobTypeValue:function(id){
       var rate = 0.0;
       $.each(this.jobTypeRates, function(key,value){
         if(value.labour_job_type_id == id){
           rate = value.rate
         }
       })

      return rate;
      
    }

  }
})
});
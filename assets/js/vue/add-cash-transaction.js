window.CASH_TRANSACTIONS= new Vue({
	el: '#add-cash-transaction',
	data: {
					transactions: [],
 				  
 				  credit:{
 				  					amount: [], party_ids: []
 				  },
				  debit:{
				  	amount: [], party_ids: []
				  },

	   	 },

	computed: {},

	methods: {
		
		filterTransactions:function(type){
			var transactions = [];
			 
			$.each(this.transactions, function(key, transRecord){
				 if(transRecord.transaction_type == type)
				  	transactions.push(transRecord);
			});

			return transactions;

		},

		iteratorInsert: function(index){
			var self = this;
			var lastEle = this.iterator[index][this.iterator[index].length-1];
			this.iterator[index].push(lastEle+1);
		},

		insertTransactions: function(record){
				var hash = sha1(JSON.stringify(record)+Date.now()+Math.random());
				record.hash = hash;
				this.transactions.push(record);
		},

		insertEmptyTransaction: function(type){
				 return window.CASH_TRANSACTIONS.insertTransactions({
				 	  'id':'',
				 	  'transaction_type' : type,	
						'secondary_account_id':0,
						'amount':0,
						'transaction_date':'',
						'remarks':''
					});
		},

		removeTransaction: function(hash){
				var trans = this.transactions;
				$.each(trans, function(key, value){
					 if(hash == value.hash){
					 	  trans.splice(key,1);
					 	  return false;
					 }
				});

				this.transactions = trans;
	  },

	  updateItem:function(hash,item,val_key){

	  	var transactions = this.transactions;
 			
	  	$.each(transactions, function(key,value){
	  		 if(value.hash == hash){
	  		 		value.val_key = item.val_key;
	  		 }
	  	});

	  	 this.transactions = transactions;
	  },
	  
	  totalCredit:function(){
	  	var credit = 0.00;
	  	$.each(this.transactions, function(key,value){
	  		 if(value.transaction_type == 'CREDIT'){
	  		 	 credit = credit + parseFloat(value.amount);
	  		 	 	 if(isNaN(credit))
	  		 	 	    credit = 0.00;
	  		 }
	  	});

	  	return credit;
	  },

	  totalDebit:function(){
	  	var debit = 0.00;
	  	$.each(this.transactions, function(key,value){
	  		 if(value.transaction_type == 'DEBIT'){
	  		 	 debit = debit + parseFloat(value.amount);
	  		 	 if(isNaN(debit))
	  		 	 	debit = 0.00;
	  		 }
	  	});
	  	
	  	return debit;
	  },

	  closingBalance:function(){
	  	 var closing_balance = 0.00;
	  	 closing_balance = window.for_js.openingBalance;
	  	 closing_balance =  closing_balance + this.totalCredit() - this.totalDebit()
	  	 return closing_balance;
	  },

		iteratorRemove: function(index, id){
			if(this.iterator[index].length <= 1)
				return alert('Cannot delete there should be at-least one entry.')
			this.iterator[index].splice(this.iterator[index].indexOf(id), 1);
		},

		onSubmit: function(e){
		},

		calculateBalance: function(e){
			$('#add-cash-transaction form').submit();
		}
	}
});

jQuery(function(){

	$.each(v('transactions'), function(key, value){
			 window.CASH_TRANSACTIONS.insertTransactions(value);
	});

	window.CASH_TRANSACTIONS.insertTransactions({'transaction_type' : 'DEBIT',	
		'id':'',
		'secondary_account_id':0,
		'amount':0,
		'transaction_date':'',
		'remarks':''
	});
	window.CASH_TRANSACTIONS.insertTransactions({'transaction_type' : 'CREDIT',	
		'id':'',
		'secondary_account_id':0,
		'amount':0,
		'transaction_date':'',
		'remarks':''
	});

});
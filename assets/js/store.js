window.Store = {
	query: function(entityNameOrArr){
		return new Query(entityNameOrArr);
	}
};

function Query(entityNameOrArr){
	this.entityNameOrArr = entityNameOrArr;

	this.rows = null;
	if(entityNameOrArr.constructor === Array)
		this.rows = entityNameOrArr;

	if(!this.rows)
		this.rows = window.for_js[this.entityNameOrArr];

	if(!this.rows)
		throw "Invalid Input, Query only accepts Array as rows.";
}


Query.prototype.where = function(key,value){
	this.rows = $.grep(this.rows,function(item){
		return (item[key] == value);
	});	
	return this;
};

//performs search on a sub queriable object collection
Query.prototype.whereEachOf = function(key,callBack){
	this.rows = $.grep(this.rows,function(item){
		var q = callBack(Store.query(item[key]));
		return Boolean(q.count());
	});	
	return this;
};

Query.prototype.get = function(){
	return this.rows;
};

Query.prototype.first = function(){
	if(!this.rows.length)
		return null;
	var first  = this.rows.shift();
	this.rows.unshift(first);
	return first;	
};

Query.prototype.count = function(){
	return this.rows.length;	
};


Query.prototype.find = function(val){
	return this.where('id',val).first();
};

Query.prototype.column = function(column){
	var collection = [];
	$.each(this.rows,function(key, row){
		if(row[column])
			collection.push(row[column])
	});
	return collection;
};

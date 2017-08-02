function env(key,_default){
	if(!window.__ENV__)
		return _default;
	if(!window.__ENV__[key])
		return _default;
	return window.__ENV__[key];
}
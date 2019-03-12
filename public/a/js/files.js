$.fn.files = function($a,$b,fields,form){
 var a = $(this).find('select[lay-filter=a]');
 var b = $(this).find('select[lay-filter=b]');
  //-------
function aa($a){
	//清空
	a.html('');
	bool = true;
	for(var i in fields){
		if($a==fields[i].name){
				bool = false;
                bList = fields[i].list;
                a.append("<option selected value='"+fields[i].name+"'>"+fields[i].name+"</option>")
       }else{
                a.append("<option value='"+fields[i].name+"'>"+fields[i].name+"</option>")
		}
}
	if(bool){
		 bList = fields[0].list;
	}
}
function bb($b){
	b.html('');
		for(var i in bList){
		if($b==bList[i]){

                b.append("<option selected value='"+bList[i]+"'>"+bList[i]+"</option>")
       }else{
                b.append("<option value='"+bList[i]+"'>"+bList[i]+"</option>")
		}
}
	
}
aa($a);
bb($b);
form.render('select');
form.on('select(a)', function(data){
        $a = data.value;
        aa($a);
		bb('');
        form.render('select');
 });


}


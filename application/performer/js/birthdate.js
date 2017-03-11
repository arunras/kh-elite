/***********************************************
* Drop Down Date select script- by JavaScriptKit.com
* This notice MUST stay intact for use
* Visit JavaScript Kit at http://www.javascriptkit.com/ for this script and more
* WARNING -------------------------------------------------------!-
* This javascript has been modified by *bdhacker* for real life use
* ishafiul@gmail.com
* http://bdhacker.wordpress.com
***********************************************/

//var monthtext=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
var monthtext=['01','02','03','04','05','06','07','08','09','10','11','12'];
function date_populate(dayfield, monthfield, yearfield){
    var today=new Date();
    var dayfield=document.getElementById(dayfield)
    var monthfield=document.getElementById(monthfield)
    var yearfield=document.getElementById(yearfield)
	//DAy
    for (var i=0; i<31; i++){
		var day = (i < 9 ? '0' : '') + (i+1);
        dayfield.options[i+1]=new Option(day, day)
	}
		//dayfield.options[0]= new Option('Day:','');
		dayfield.options[0]= new Option('- -','');
    //dayfield.options[today.getDate()]=new Option(today.getDate(), today.getDate(), true, true) /*select today's day*/
    //MONTH
	for (var m=0; m<12; m++){
        monthfield.options[m+1]=new Option(monthtext[m], monthtext[m])
	}
	monthfield.options[0]= new Option('- -','');
    //monthfield.options[today.getMonth()]=new Option(monthtext[today.getMonth()], monthtext[today.getMonth()], true, true) //select today's month
    var thisyear=today.getFullYear()
    //YEAR
	for (var y=1; y<100; y++){
        yearfield.options[y]=new Option(thisyear, thisyear)
        thisyear-=1
    }
	yearfield.options[0]= new Option('- -','');
    //yearfield.options[0]=new Option(today.getFullYear(), today.getFullYear(), true, true) //select today's year
}

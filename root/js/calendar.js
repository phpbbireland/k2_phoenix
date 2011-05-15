/**
*
* @package calendar
* @version $Id: functions_calendar.php 2008-07-10 21:16:00Z NeXur, livewirestu and Michaelo $
* @copyright (c) 2008 phpbbireland
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* Description: main js file for event and topic calendar mod.
* Notes: This project was started after the calendar project by John Cottage (jcc264) on phpbb.com went stale
*        It has since been completely overhauled, although still contains some remnants of John's original code
*/

var now = new Date;
var current_day = now.getDay();
var current_month=now.getMonth();
var current_year=now.getFullYear();
var end_current_day = now.getDay();
var end_current_month=now.getMonth();
var end_current_year=now.getFullYear();

var current_mins='00';
var current_hour='01';
var current_ampm='am';

var tempColor;

var month_array=new Array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
var month_days=new Array('31','28','31','30','31','30','31','31','30','31','30','31');
var month_days_leap=new Array('31','29','31','30','31','30','31','31','30','31','30','31');

var dateTarget;
var timeTarget;

if (document.addEventListener)
                document.addEventListener('click',check_click,false);
        else if (document.attachEvent){
           document.attachEvent("onclick",check_click);
        }



function check_click(event_obj)
{

if (navigator.appName == 'Microsoft Internet Explorer')
  {     s = event_obj.srcElement;  }
  else
  {       s=event_obj.target;
  }
        while(s) {
                //if (s.id =='mins' || s.id =='ampm'|| s.id =='hrs' ){return;}
                if (s==document.getElementById('date_java'))
                {
                        time_close();
                        return;
                }
                if (s==document.getElementById('time_java'))
                {
                        date_close();
                        return;
                }
                if (s==document.getElementById('end_date_java'))
                {
                        end_time_close();
                        return;
                }
                if (s==document.getElementById('end_time_java'))
                {
                        end_date_close();
                        return;
                }
                s=s.parentNode;
        }
        time_close();
        date_close();
}

//Show Hide Functions
function time_show(obj)
{
        document.getElementById('time_java').style.left=Left(obj)+"px";
        document.getElementById('time_java').style.top=Top(obj)+"px";  
        document.getElementById('time_java').style.display='';
        timeTarget = obj;
        if(obj.value == '')
            obj.value = '01:00 am';
        document.getElementById('hrs').value = current_hour = obj.value.substr(0,2);
        document.getElementById('mins').value = current_mins = obj.value.substr(3,2);
        document.getElementById('ampm').value = current_ampm = obj.value.substr(6,2);
        update_time();
}       
        
function time_close()
{
        document.getElementById('time_java').style.display='none';
}

function date_show(obj)
{
        if(obj.value != '')
        {
            var currentDate = new Array();
            currentDate = obj.value.split('-');
            current_day = parseInt(currentDate[1]);            
            current_month = parseInt(currentDate[0]) - 1;
            current_year = parseInt(currentDate[2]);
        }
        else
        {
            current_day = now.getDay();
            current_month = now.getMonth();
            current_year = now.getFullYear();
        }
        prepcalendar(current_day, current_month, current_year);
        document.getElementById('date_java').style.left=Left(obj)+"px";
        document.getElementById('date_java').style.top=Top(obj)+"px";  
        document.getElementById('date_java').style.display='';
        dateTarget = obj;
}

function date_close()
{
        document.getElementById('date_java').style.display='none';
}

//Positioning functions
function Left(obj)
{
    var offsetLeft = 0;
    while (obj)
        {
        offsetLeft += obj.offsetLeft;
        obj = obj.offsetParent;
    }
        return offsetLeft;
}

function Top(obj)
{
    var offsetTop = 20;
    while (obj)
        {
        offsetTop += obj.offsetTop;
        obj = obj.offsetParent;
    }
        return offsetTop;
}

//Display functions
function prepcalendar(display_day, display_month, display_year, limit_low, limit_hi) {
    td=new Date();
    td.setDate(1);
    td.setFullYear(display_year);
    td.setMonth(display_month);
    var day_of_week=td.getDay();

    document.getElementById('month_name').innerHTML=month_array[display_month]+ ' ' + display_year;
    var this_month_array=((display_year%4)==0)?month_days_leap:month_days;

            
    for(var d=1;d<=42;d++)
    {
        
        this_td = document.getElementById('d' + d);
        set_style(this_td);
        if ( (d>=(day_of_week+1)) && (d<=(parseInt(this_month_array[display_month])+parseInt(day_of_week))) )
        {
            //This is a valid days
            this_td.innerHTML = d-day_of_week;
            this_td.onmouseover=mouse_over;
            this_td.onmouseout=mouse_out;
            this_td.onclick=mouse_click;
            this_td.className = 'bg3';                        
        }
        else
        {
            //This is a blank day
            this_td.innerHTML='&nbsp;';
            this_td.onmouseover=null;
            this_td.onmouseout=null;
            this_td.onclick=null;
            this_td.style.cursor='default';
            this_td.className = 'bg2';
        }
    }
}

function next_month()
{
    current_month=current_month+1;
    if(current_month==12)
    {
            current_month=0;
            current_year=current_year+1;
    }
    prepcalendar(current_day, current_month, current_year);
}

function prev_month()
{
    if(current_month==0)
    {
            current_month=11;
            current_year=current_year-1;
    }
    else
    {
            current_month=current_month-1;
    }
    prepcalendar(current_day, current_month, current_year);
}

function setH(obj)
{
    current_hour=obj.value;
    update_time();
}

function setM(obj)
{
    current_mins=obj.value;
    update_time();
}

function setAP(obj)
{
    current_ampm=obj.value;
    update_time();
}

function update_time()
{
    timeTarget.value = current_hour+':'+current_mins+' '+current_ampm;
    validateForm('postform', 'calendar:get_repeat_dates', 'repeat_dates');
}

//style Setting
function set_style(obj)
{
    obj.style.textAlign='center';
    obj.style.textDecoration='none';
    obj.style.border='1px solid';
    obj.style.cursor='pointer';
}

//Mouse Handleing for the month

function mouse_over(obj)
{
    if (navigator.appName == 'Microsoft Internet Explorer')
    {   
        elem = document.getElementById(event.srcElement.id);
        elem.className = 'bghover';
    }
    else
    {
        elem = document.getElementById(obj.target.id);
        elem.className = 'bghover';
    }
}

function mouse_out(obj) 
{
    if (navigator.appName == 'Microsoft Internet Explorer')
    {
        event.srcElement.className = 'bg3';
    }
    else
    {
        obj.target.className = 'bg3';
    }
}


function mouse_click(obj)
{
    if (navigator.appName == 'Microsoft Internet Explorer')
    {     
        current_day = event.srcElement.innerHTML;
    }
    else
    {
        current_day = obj.target.innerHTML;
    }

    if(current_day>9)
    {
        day=current_day;
    }
    else
    {
        day = '0'+current_day;
    }
    
    if(current_month<9)
    {
        month='0'+current_month;
    }
    month=current_month+1;
    
    dateTarget.value=month+'-'+day+'-'+current_year;
    date_close();
    validateForm('postform', 'calendar:get_repeat_dates', 'repeat_dates');
}

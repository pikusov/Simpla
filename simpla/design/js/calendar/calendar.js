// date format
// -----------
xcDateFormat="dd.mm.yyyy";


// css conf
// --------
xcCSSPanel="panel";

xcCSSHeadBlock="row_head";
xcCSSHead="head";

xcCSSArrowMonthPrev=["arrow_prev", "arrow_prev_over", "arrow_prev_down"];
xcCSSArrowMonthNext=["arrow_next", "arrow_next_over", "arrow_next_down"];

xcCSSArrowYearPrev=["arrow_prev", "arrow_prev_over", "arrow_prev_down"];
xcCSSArrowYearNext=["arrow_next", "arrow_next_over", "arrow_next_down"];

xcCSSWeekdayBlock="row_week";
xcCSSWeekday="weekday";

xcCSSDayBlock="row_day";
xcCSSDay=["day", "day_over", "day_down", "day_disabled"];
xcCSSDayCurrent=["day_current", "", ""];
xcCSSDaySpecial=["day_special", "day_disabled"];
xcCSSDayEmpty="day_empty";

xcCSSFootBlock="row_foot";
xcCSSFootToday=["foot", "foot_over", "foot_down"];
xcCSSFootClear=["foot", "foot_over", "foot_down"];
xcCSSFootBack=["foot", "foot_over", "foot_down"];
xcCSSFootClose=["foot", "foot_over", "foot_down"];
xcCSSFootReset=["foot", "foot_over", "foot_down"];


// layout conf
// -----------
xcMonthNames=["Январь", "Февраль", "Март", "Апрел", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
//xcMonthNames=["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
xcMonthShortNames=["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
xcMonthPrefix="";
xcMonthSuffix="";

xcYearDigits=["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
xcYearPrefix="";
xcYearSuffix="";

xcHeadSeparator=" "; // separator string between year and month
xcHeadTagOrder=1; // 1: month/year, 0: year/month
xcHeadTagAdjustment=1; // 1: 100% width, 0: actual width

xcArrowMonth=["&#139;", "&#155;"];
xcArrowYear=["&#171;", "&#187;"];
xcArrowSwitch=[1, 1]; // [year, month] 1:on, 0:off
xcArrowPosition=0; // 0:in head block, 1:in foot block

// names for days
xcWeekdayNames=["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
xcWeekdayShortNames=["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
xcWeekdayDisplay=["ВС", "ПН","ВТ","СР","ЧТ","ПТ","СБ","ВС"];

// foot links
xcFootTags=["сегодня", "очистить", "назад", "&times;", "сбросить", "_Today_", "_Back_", "_Reset_"];
xcFootTagSwitch=[0, 0, 0, 0, 0, 0, 0, 0]; // [today, clear, back, close, reset, _today_, _back_, _reset_] non-zero:display order, 0:off
xcFootTagAdjustment=0; // 1: % width, 0: actual width

// easy workaround for grid style
xcGridWidth=0; // used as cellspacing

// others
xcBaseZIndex=100; // z-index for calendar layers
xcMultiCalendar=0; // 1:multi-calendar, 0:single-calendar
xcShowCurrentDate=1; // 1:highlight current date/today, 0:no highlight
xcWeekStart=1; // 0:Sunday, 1:Monday
xcAutoHide=500; // 0: no auto hide, non-zero:auto hide interval in ms
xcStickyMode=0; // 0:non-sticky, 1:sticky

// day contents
xcDayContents=["&nbsp;", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"];
xcDayContentsDisabled=xcDayContents;
xcDayContentsCurrent=xcDayContents;

xcMods=[];

// GLOBAL FUNCTIONS SECTION BEGIN *******************************************************************************************************
function converToMinutes(s) {
		var c = s.split(':');
		return parseInt(c[0]) * 60 + parseInt(c[1]);
	}

	// when hour is in format like this 
	// 12:3 it converts this time to 12:30
function parseTime(s) {
	if (parseInt(s) % 60 == 0){
		return Math.floor(parseInt(s) / 60) + ":" + "00";
	} else {
		return Math.floor(parseInt(s) / 60) + ":" + (( parseInt(s) % 60  < 10 ) ?  "0"+(parseInt(s)%60) : (parseInt(s)%60) )  ;
	}
}

function getExamID() {
	query = window.location.search.substring(1); 
	queryPart = query.split('&');
	examID = null ; 
	for ( var idx in queryPart ) {  
		if ( queryPart[idx].match(/examID/) != null  )  { 
			examID = queryPart[idx].match(/\d+/ ) ; 
			return examID[0] ;   
		}
	}     
	return examID ;  	
} ;

function parseTimeToDatabaseFormat ($time) { 
	return $time+":00"; 
} ; 

// GLOBAL FUNCTIONS SECTION END *********************************************************************************************************

jQuery( document ).ready(function( $ ) {

// CLASSES & FUNCTIONS SECTION BEGIN ****************************************************************************************************
	// klasa odpowiedzialna za wymianę informacji z bazą danych 
	function DatabaseModificationsSaver() { 
		this.addSingleExamUnit = function ( $day , $timeFrom , $timeTo) { 
			examID	= getExamID () ;
			$currentClass = this ; 
			return $.ajax({
				url: 'lib/Ajax/AjaxCalendarSaver.php',
				async: false , 
				type: 'post',
				data: { 'requestType' : 'addExamUnit' ,
								'day' : $day ,  
								'examID' : examID , 
								'timeFrom' : $timeFrom , 
								'timeTo' : $timeTo 
							},
				success: function(data, status) { 
					//console.log(data) ; 
					if(data.status.trim() === "dataSavedProperly") {
						console.log ("Exam unit (examID : " + examID + " day " + $day + ", timeFrom : " + $timeFrom + ", timeTo : "+ $timeTo +") dodano do bazy poprawnie" );
						return ; 
					} 
					console.log("Dodawanie do bazy exam unit (examID : " + examID + " day " + $day + ", timeFrom : " + $timeFrom + ", timeTo : "+ $timeTo +") nie powiodło się ");  	 
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(textStatus);
					console.log(errorThrown);
				}
			}); 
		} ;	
		// for speed purpose 
		this.addExamUnitsBlock = function ( $ExamUnitsBlock ) { 
			examID	= getExamID () ;
			$currentClass = this ; 
			return $.ajax({
					url: 'lib/Ajax/AjaxCalendarSaver.php',
					//async: false , 
					type: 'post',
					contentType: 'application/json;  charset=utf-8' , 
					data: JSON.stringify({ 'requestType' : 'addExamUnitsBlock' ,
							 'examID' : examID ,
							 'examUnitsBlock' :  $ExamUnitsBlock 
						   }) ,
					success: function(data, status) { 
						console.log("wszystko ok ");
						if(data.status.trim() === "dataSavedProperly") {
							console.log ("Blok ExamUnits dodano do bazy poprawnie" );
							return ; 
						} 
						console.log("Dodawanie do bazy bloku ExamUnits nie powiodło się ");  	 
					},
					error: function(jqXHR, textStatus, errorThrown) {
						//alert ( "cos jest sle " ) ;
						console.log(textStatus);
						console.log(errorThrown);
					}
			}); 
		}; 
		
		this.removeDay = function ( $day  ) { 
			examID	= getExamID () ;
			$currentClass = this ; 
			return $.ajax({
				url: 'lib/Ajax/AjaxCalendarSaver.php',
				async: false , 
				type: 'post',
				data: { 'requestType' : 'removeDay' ,
							'day' : $day ,  
							'examID' : examID  
					  },
				success: function(data, status) { 
					//console.log(data) ; 
					if(data.status.trim() === "dataSavedProperly") {
						console.log ("Dzień " + $day + " usunięto z bazy poprawnie" );
						return ; 
					} 
					console.log("Dzień " + $day + " usuwanie z bazy nie powiodło się ");  	 
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(textStatus);
					console.log(errorThrown);
				}
			}); 
		} ; 
		
		this.removeSingleExamUnit = function ( $day , $timeFrom ) { 
			$timeFrom = parseTimeToDatabaseFormat ( $timeFrom ) ; 
			examID	= getExamID () ;
			$currentClass = this ; 
			return $.ajax({
				url: 'lib/Ajax/AjaxCalendarSaver.php',
				async: false , 
				type: 'post',
				data: { 'requestType' : 'removeExamUnit' ,
							'day' : $day ,  
							'examID' : examID , 
							'timeFrom' : $timeFrom 
						},
				success: function(data, status) { 
					//console.log(data) ; 
					if(data.status.trim() === "dataSavedProperly") {
						console.log ("Exam unit (examID: " + examID + ", day :" + $day + ", timeFrom : " + $timeFrom + ") usunięto z bazy poprawnie" );
						return ; 
					} 
					console.log("Usuwanie z bazy exam unit (examID: " + examID + ", day: " + $day + ", timeFrom : " + $timeFrom + ") nie powiodło się ");  	 
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(textStatus);
					console.log(errorThrown);
				}
			}); 
		} ; 
	}  

	// klasa wymiany danych na kartach dodaj egzamin 

	function ExamUnit(bHour, eHour , studentName , studentSurname) {
		this.bHour = bHour;
		this.eHour = eHour;
		this.studentName = studentName ; 
		this.studentSurname = studentSurname ;
	}
	function Exam(name, durration){
		this.name = name;
		this.durration = durration;
		this.day = new Array();
		this.blockedUnits = new Array();
		
		this.addTerm = function (date, begHour, endHour, durat) {
			var bHour = converToMinutes(begHour);
			var eHour = converToMinutes(endHour);
			var diff = eHour - bHour;
			var count = diff / durat;
			for (var i=0;i<count;i++){
				
				if(this.day[date] === undefined){
					this.day[date] = new Array();
				}
				var conv1 = parseTime(bHour + durat * i);      
				var conv2 = parseTime(bHour + durat * (i + 1)); 
				var examUnit = new ExamUnit(conv1, conv2);
				this.day[date].push(examUnit);
			}
			this.sortExam () ; 
		};

		this.sortExam = function ( ) { 
			// sort days 
			this.sortDaysArray ( )  ;
			// sort within days 
			this.sortAllExamUnits();
		} ;
		
		this.addSingleExamUnit = function ( date, begHour, endHour , studentName , studentSurname ) {
			if(this.day[date] === undefined) {
					this.day[date] = new Array();
			}
			$examUnit = new ExamUnit(begHour, endHour , studentName , studentSurname);
			this.day[date].push($examUnit); 
		} ;
		
		this.delTerm = function(date) {
			delete this.day[date];
		};
		
		this.blockUnit = function(date, fromHour, toHour) {
			if(this.blockedUnits[date] === undefined) {
				this.blockedUnits[date] = new Array();
			}
			this.blockedUnits[date].push(fromHour);
			this.blockedUnits[date].push(fromHour);
		};

			// sort numbers in asc order 
		this.sortNumbers = function ( arg1 , arg2  ) {  
			return arg1 - arg2 ;  
		} ; 
		
		this.sortAllExamUnits = function (){ 
			for ( var date in this.day ) {
				this.sortExamUnit ( date  ) ;
			} 
		} ; 
		
		this.sortExamUnit = function(date){
			this.day[date].sort(this.compareTwoExamUnits) ;  
		};
		
		this.compareTwoExamUnits =  function compare(a,b) {
			if ( converToMinutes (a.bHour ) < converToMinutes (b.bHour ))
				return -1;
			if (converToMinutes (a.bHour ) > converToMinutes (b.bHour ))
				return 1;
			return 0;
		}
		
		this.findExamUnitByBeginHour = function ( date , bHour ) {
			for ( var examUnitIdx in this.day[date] ) { 
				//console.log ( this.day[date][examUnitIdx].bHour + " " +  bHour ) ; 
				if ( this.day[date][examUnitIdx].bHour.trim() == bHour.trim() ) {
					//console.log ( "match found " ) ; 
					return this.day[date][examUnitIdx] ; 
				}
			}	
			return null ; 
		} ;
		
		this.removeDaysWithoutExams = function ( ) { 
			for ( var date in this.day ) {  
				if ( this.day[date].length === 0 ) {
					delete this.day[ date ]  ;
				} 
			} 
		} ; 
		
		this.sortDaysArray  = function ( ) { 
			var sortedDaysArray = new Array( ); 
			var keyOrder = new Array () ; 
			for (var key in this.day) {
				keyOrder.push(key);
			}
			keyOrder.sort ( this.sortDaysKey ) ;
			for ( var i= 0 ; i < keyOrder.length ; i++ ) { 
				sortedDaysArray[keyOrder[i]] = ( this.day[ keyOrder[i] ] )  ;
			} 
			this.day = sortedDaysArray ; 
		} ; 
		
		this.sortDaysKey = function ( arg1 , arg2 ) {  
			var dateRegexPattern = /^(\d{4})[\/\- ](\d{2})[\/\- ](\d{2})/;
			a1 = arg1.replace(dateRegexPattern,"$1$2$3");
			a2 = arg2.replace(dateRegexPattern,"$1$2$3");
			if ( a1 > a2 ) return 1 ; 
			else if ( a2 > a1 ) return -1 ; 
			else return 0 ;
		} ; 
		
		this.removeExamHoursForDay = function ( date , startHour   )  {
			for (var indx in this.day[date]) {
				if ( this.day[date][indx].bHour == startHour ) { 
						this.day[date].splice(indx, 1);
						this.removeDaysWithoutExams() ; 
				} 
			} 
		} ;
	}    
	
	
	function DayControl ( day , examUnits) {
		
		this.day = day ; 
		this.examUnits = examUnits ; 
		this.separatorPositions = new Array () ; 
		this.findSeparatorPositions = function ( ) { 
			for ( var i=0; i<examUnits.length-1 ; i++ ) { 
				if ( examUnits[i].eHour !== examUnits[i+1].bHour  ) { 
					this.separatorPositions.push(i);
				} 
			} 
		} ; 
		
		this.controlStyleBegin = function ( date) {
			//alert ( "height : " + this.height) ; 
			begin = '<div class="col-xs-3 col-sm-3 col-md-3">' +	 
					'	<div class="panel panel-primary "> ' +
					'		<div class="panel-heading" >' + date + ' </div> ' +  
					'		<div class="panel-body" id="' + date + '" style="height:' + this.height +  'px; overflow-y: scroll;">' +
					' 			<table class="table">' +  
					' 				<thead> ' + 
					'					<tr> ' + 
					'						<th colspan="2" style="white-space:nowrap">usuń termin</th>' +
					'					</tr>' +
					'				</thead> ' +
					'				<tbody>' ; 
			return begin  ; 
		} ; 
			
		
		this.controlStyleEnd = function (date) {
			end = '						</tbody>' +
				  '				</table>' +
				  '			</div>'+
				  '			<button type="button" class="btn btn-danger" id="removeDayButton" style="float:right;" name="'+ date + '">' +
				  '				<i class="glyphicon glyphicon-minus" style="font-size:20px; font-weight:bold;"></i>'+
				  '			</button>'+
				  '		</div>'+
				  '		</div>' ; 
			return end  ; 
		} ;
		
		this.controlAddExamUnit = function ( startTime , endTime , name , surname ) { 
			// method to be overloaded 
		} ; 
		
		this.controlAddSeparator = function ( ) { 
			return '<tr><td colspan="2" style="text-align:center;"> *** </td></tr>' ; 
		} ;
	}

	DayControl.prototype.height = 400; 
	/*  
	 *	extend classes from DayControl
	 */
	
	function SimpleDayControl ( day , examUnits ) { 
		DayControl.call(this , day , examUnits);
	} 
	
	SimpleDayControl.prototype = new DayControl () ; 
	
	SimpleDayControl.prototype.constructor = SimpleDayControl ;  
	
	SimpleDayControl.prototype.controlAddExamUnit = function ( startTime , endTime , name , surname ) { 
			examUnit =	'<tr>'
						+ '		<td><i style="cursor:pointer;" id="removeRecordIcon" class="glyphicon glyphicon-trash"></i></td> '
						+ '		<td style="white-space:nowrap">'+startTime+'-'+endTime+'</td> ' 
						+ '</tr> ' ; 
			return examUnit ; 
	}  
	
	SimpleDayControl.prototype.printControl = function ( ) {   
			if ( this.examUnits.length == 0 ) { 
				return ; 
			} 
			  
			htmlControl = this.controlStyleBegin ( this.day ); 
			this.findSeparatorPositions();  

			var i = 0 ; 
			var separatorIndex = this.separatorPositions.shift();
			
			for ( var item in this.examUnits ) { 
				htmlControl += SimpleDayControl.prototype.controlAddExamUnit(  this.examUnits[item].bHour , this.examUnits[item].eHour , null , null);
				if ( separatorIndex == i ) { 
					separatorIndex = this.separatorPositions.shift(); 
					htmlControl += this.controlAddSeparator () ;
				} 
				i++ ; 
			} 
			htmlControl += this.controlAddSeparator () ;
			htmlControl += this.controlStyleEnd (this.day) ;
		    // document.write ( htmlControl  ); 
			return htmlControl ; 
	} ;  
	

	function ExtendedDayControl ( day , examUnits ) { 
		DayControl.call(this , day , examUnits);
	} 
	
	ExtendedDayControl.prototype = new DayControl () ; 
	
	ExtendedDayControl.prototype.constructor = SimpleDayControl ;  
	
	ExtendedDayControl.prototype.controlAddExamUnit = function ( startTime , endTime , name , surname ) { 
			examUnit =	'<tr>'
						+ '		<td><i  style="cursor:pointer;" id="removeRecordIcon" class="glyphicon glyphicon-trash"></i></td> '
						+ '		<td '  + (( name == null && surname == null ) ?  'class="danger"' : 'class="success"')  + ' >' +  startTime + ' - ' + endTime +'<br />' 
						+(( name == null && surname == null ) ? 'termin nieprzypisany' : ( name + ' ' + surname )) + '</td> ' 
						+ '</tr> ' ; 
			return examUnit ; 
	}  
	
	ExtendedDayControl.prototype.printControl = function ( ) {   
			if ( this.examUnits.length == 0 ) { 
				return ; 
			} 
			  
			htmlControl = this.controlStyleBegin ( this.day ); 
			this.findSeparatorPositions();  

			var i = 0 ; 
			var separatorIndex = this.separatorPositions.shift();
			
			for ( var item in this.examUnits )  { 
				htmlControl += ExtendedDayControl.prototype.controlAddExamUnit(  this.examUnits[item].bHour , this.examUnits[item].eHour , this.examUnits[item].studentName , this.examUnits[item].studentSurname  );
				if ( separatorIndex == i ) { 
					separatorIndex = this.separatorPositions.shift(); 
					htmlControl += this.controlAddSeparator () ;
				} 
				i++ ; 
			} 
			htmlControl += this.controlAddSeparator () ;
			htmlControl += this.controlStyleEnd (this.day) ;
		    // document.write ( htmlControl  ); 
			return htmlControl ; 
	} ;  
	
	
	function CalendarControl ( displayStudentName )  {
		this.displayStudentName = displayStudentName ; 
		this.examDays = new Array() ; 
		this.printCalendar = function ( ) 	{ 
			//alert ( this.examDays.length ) ;
			var calendarControl = "" ; 
			var maxDaysNumPerRibbon = 4 ; 
			var daysCounter = 0 ; 
			
			calendarControl+=this.addRibbonStart() ; 
			
			for(var day in this.examDays) {
				if ( (daysCounter % maxDaysNumPerRibbon == 0) && ( daysCounter != 0 )    ) { 
					calendarControl+=this.addRibbonEnd ();
					calendarControl+="<hr>" ;
					calendarControl+=this.addRibbonStart() ; 
				} 
				if ( this.displayStudentName == true ) {  
					calendarDayControl = new ExtendedDayControl ( day , this.examDays[day]) ;
				} else { 
					calendarDayControl = new SimpleDayControl ( day , this.examDays[day]) ;
				} 
				calendarControl+=calendarDayControl.printControl();
				daysCounter++; 
			} 
			
			calendarControl+=this.addRibbonEnd ();
		
			$("#calendar-control").html(calendarControl);
		} ; 
		
		this.addRibbonStart = function ( ) { 
			start = ' <div class="row" style="background:url(img/calendarPanel.png);" >' ;  
			return start ; 
		} ; 
		
	
		this.addRibbonEnd = function () { 
			end = '</div>' ;  
			return end ; 
		} ;
	} 

	function EditExamCalendarManager() { 
		this.exam = null ; 
		this.calendarControl = null ;  
		this.databaseModificationsSaver = new DatabaseModificationsSaver() ;
		this.sendAjaxExamCalendarRequest = function ( ) {
			examID	= getExamID () ;
			$currentClass = this ; 
			$.ajax({
				url: 'lib/Ajax/AjaxExamCalendarRequest.php',
				async: false, 
				type: 'post',
				data: { 'examID' : examID },
				success: function(data, status) { 
					if(data.status.trim() === "dataRecived") {
						if (data.examID.trim() === "existsInDB") {
							//console.log( "odebrano dane " ) ; 
							//console.log ( data ) ; 
							$currentClass.calendarControl = new CalendarControl ( true ) ;  // calendar with student name  
							$currentClass.insertExamUnitsToCalendar(data); 
							return data; 
						} 
						//console.log ( data ) ;
					} 
					console.log("Zapytanie ajax nie powiodło się ( Nie udało się sprawdzić czy exam ID występuje w bazie )");  	 
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(textStatus);
					console.log(errorThrown);
				}
			}); 
		} ;	
		
		this.insertExamUnits = function ( date , begHour , endHour , duration  ) {  
			$.when ( this.insertExamUnitsToDatabase (date , begHour , endHour , duration ))
				.then (this.updatePageViewAfterExamUnitsBlockAdition(date , begHour , endHour , duration )) ; 
		} ; 
		
		this.insertExamUnitsToDatabase = function ( date , begHour , endHour , durat ) { 
			var bHour = converToMinutes(begHour);
			var eHour = converToMinutes(endHour);
			var diff = eHour - bHour;
			var count = diff / durat;
			var ExamUnitsBlock = [];
			for (var i=0;i<count;i++) {
				var conv1 = parseTime(bHour + durat * i);      
				var conv2 = parseTime(bHour + durat * (i + 1)); 
				ExamUnitsBlock.push({ 'day' : date , 'timeFrom' :  parseTimeToDatabaseFormat(conv1) , 'timeTo' :  parseTimeToDatabaseFormat(conv2) });
			}
			return this.databaseModificationsSaver.addExamUnitsBlock(ExamUnitsBlock) ; 
		} ;
		
		this.removeAllUnitsForDay = function ( date ) {
			this.databaseModificationsSaver.removeDay (date );
			this.updatePageViewAfterDayRemoval(date);
		} ; 
		
		this.checkIfStudentsEnroledOnDay = function ( date ) { 
			for (var examUnitIndex=0 ; examUnitIndex< this.exam.day[date].length ; examUnitIndex++) { 
				if ( this.exam.day[date][examUnitIndex].studentName != null 
					|| this.exam.day[date][examUnitIndex].studentSurame != null 
				) {  
					return true ;
				} 
			} ;
			return false ; 
		} ; 
		
		this.checkIfStudentEnroledOnExamUnit = function ( date , begHour ) { 
			for (var examUnitIndex=0 ; examUnitIndex< this.exam.day[date].length ; examUnitIndex++) {
				if ( this.exam.day[date][examUnitIndex].bHour == begHour ) 
					if ( this.exam.day[date][examUnitIndex].studentName != null 
						|| this.exam.day[date][examUnitIndex].studentSurame != null )  
							return true ;  
			} 
			return false ;
		} ; 
		
		this.removeSingleExamUnit = function (date , begHour ) {
			$.when( this.databaseModificationsSaver.removeSingleExamUnit( date , begHour  ) )
				.then(this.updatePageViewAfterSingleUnitRemoval(date , begHour));	
		} ; 
		
		this.updatePageViewAfterSingleUnitRemoval = function (date , begHour) { 
			this.exam.removeExamHoursForDay(date , begHour);
			this.exam.sortExam();
			$currentClass.calendarControl = new CalendarControl ( true ) ;
			$currentClass.calendarControl.examDays = this.exam.day;
			console.log($currentClass.calendarControl.examDays);
			$currentClass.calendarControl.printCalendar();
		} ;
		
		this.updatePageViewAfterExamUnitsBlockAdition = function (date , begHour , endHour , duration) { 
			this.exam.addTerm(  date , begHour , endHour , duration );
			this.exam.sortExam();
			$currentClass.calendarControl = new CalendarControl ( true ) ; 
			$currentClass.calendarControl.examDays = this.exam.day;
			$currentClass.calendarControl.printCalendar();
		} ; 
		
		this.updatePageViewAfterDayRemoval = function (date) { 
			this.exam.delTerm(date);
			this.exam.sortExam();
			$currentClass.calendarControl = new CalendarControl ( true ) ;
			$currentClass.calendarControl.examDays = this.exam.day;
			$currentClass.calendarControl.printCalendar();
		};
		
		this.insertExamUnitsToCalendar = function($jsonExamData) { 
			this.exam = new Exam($jsonExamData.name, $jsonExamData.durration ); 
			for ( var $idx in $jsonExamData.examUnits ) {    
				$timeFrom = this.shortenTimeValue($jsonExamData.examUnits[$idx].timeFrom) ; 
				$timeTo = this.shortenTimeValue($jsonExamData.examUnits[$idx].timeTo) ;
				$studentName = ($jsonExamData.examUnits[$idx].studentName.trim() =="null" ? null : $jsonExamData.examUnits[$idx].studentName) ;
				$studentSurname = ($jsonExamData.examUnits[$idx].studentSurname.trim() =="null" ? null : $jsonExamData.examUnits[$idx].studentSurname) ;
				this.exam.addSingleExamUnit($jsonExamData.examUnits[$idx].day , $timeFrom , $timeTo , $studentName ,  $studentSurname);
			} 
			this.calendarControl.examDays = this.exam.day ;
			console.log(this.exam);
			this.calendarControl.printCalendar(); 
		} ; 
		
		this.printCalendar = function printCalendar() { 
			//console.log (this.calendarControl.examDays ) ; 
			this.calendarControl.printCalendar(); 
		} ;
		
		this.shortenTimeValue = function ( $time ) { 
			$timeArray = $time.split(':');
			return $timeArray[0]+":"+$timeArray[1];
		} ; 
	} 
// CLASSES & FUNCTIONS SECTION END ****************************************************************************************************
	
// VARIABLES SECTION BEGIN ************************************************************************************************************
	// test
	exam = new Exam ( "" , 20 ) ; 
	
	/*exam.addTerm( "21.02.03" , "10:20", "13:20", 30) ; 
	
	exam.addTerm( "21.02.03" , "14:20", "15:20", 30) ;
	
	exam.addTerm( "21.02.03" , "19:20", "21:20", 30) ;
	
	exam.addTerm( "11.02.03" , "14:20", "15:20", 30) ;
	
	exam.addTerm( "11.02.03" , "19:20", "21:20", 30) ;*/
	
	// exam.sortDaysArray("2014-12-01" , "2014-02-02") ;
	 
  calendarControl = new CalendarControl( false ) ;
  editExamCalendarManager = new EditExamCalendarManager () ; 
	
} ); 

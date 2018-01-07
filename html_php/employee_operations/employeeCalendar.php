<?php
include_once("../model/db_config.php");
class EmployeeCalendar {

    /**
     * Constructor
     */
    public function __construct(){
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
    }

    /********************* PROPERTY ********************/
    private $dayLabels = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
    private $currentYear=0;
    public $month;
    public $year;

    private $currentMonth=0;

    private $currentDay=0;

    private $currentDate=null;

    private $daysInMonth=0;

    private $naviHref= null;

    private $currentShifts;
    private $currentRowCount;
    private $shiftstaus = array('N'=>'New Shift','A'=>'Accepted','R'=>'Rejected','D'=>'Done');

//    /private $userId = 0;

    /********************* PUBLIC *********************

    /**
     * print out the calendar
     */
    public function show() {
        $year  = null;

        $month = null;

        if(null==$year&&isset($_GET['year'])){

            $year = $_GET['year'];

        }else if(null==$year){

            $year = date("Y",time());

        }

        if(null==$month&&isset($_GET['month'])){

            $month = $_GET['month'];

        }else if(null==$month){

            $month = date("m",time());

        }

        $this->currentYear=$year;

        $this->currentMonth=$month;

        $this->_getShiftsOfCurrentMonth($_SESSION['userId']); //Get the shifts once year and month are assigned

        $this->daysInMonth=$this->_daysInMonth($month,$year);

        $content='<div class="table-responsive"><table class="table table-bordered"><thead><tr>'. $this->_createNavi().'</tr><tr>'.$this->_createLabels().'</tr></thead>';

        $weeksInMonth = $this->_weeksInMonth($month,$year);

        $content.= '<tbody>';
        // Create weeks in a month
        for( $i=0; $i<$weeksInMonth; $i++ )
        {
            //Create days in a week
            $content.= '<tr>';
            for($j=1;$j<=7;$j++)
            {
                $content.=$this->_showDay($i*7+$j);
            }
            $content.= '</tr>';
        }

        $content.='</tbody></table></div>';
        return $content;
    }

    /********************* PRIVATE **********************/

    public static function getCompanyName($companyId) {
        $shiftsOfCurrentMonthSQL = "SELECT companyName from companymaster where CompanyId = :CompanyId;";
        $pdpstm = DB::getDBConnection()->prepare($shiftsOfCurrentMonthSQL);
        $pdpstm->bindValue(':CompanyId', $companyId, PDO::PARAM_INT);
        $pdpstm->execute();
        $pdpstm->setFetchMode(PDO::FETCH_ASSOC);
        $companyName = $pdpstm->fetch();
        return $companyName['companyName'];
    }

    private function _getShiftsOfCurrentMonth($user_id) {
        $shiftsOfCurrentMonthSQL = "SELECT ShiftId,day(StartTime),hour(StartTime),ShiftStatus FROM shiftmaster where AssignedTo = :userId and month(StartTime) = :month AND YEAR(StartTime) = :year;";
        $pdpstm = DB::getDBConnection()->prepare($shiftsOfCurrentMonthSQL);
        $pdpstm->bindValue(':userId', $user_id, PDO::PARAM_INT);
        $pdpstm->bindValue(':year', $this->currentYear, PDO::PARAM_STR);
        $pdpstm->bindValue(':month', $this->currentMonth, PDO::PARAM_INT);
        $pdpstm->execute();
        $pdpstm->setFetchMode(PDO::FETCH_ASSOC);
        $this->currentRowCount = $pdpstm->rowCount();
        $this->currentShifts= $pdpstm->fetchAll();
    }

    public static function _updateShiftStatus($status,$shift_id) {
            $updateShiftStatusSQL = "Update shiftmaster set ShiftStatus = :shiftStatus where ShiftId = :shiftId;";
            $pdpstm1 = DB::getDBConnection()->prepare($updateShiftStatusSQL );
            $pdpstm1->bindValue(':shiftStatus', $status, PDO::PARAM_STR);
            $pdpstm1->bindValue(':shiftId', $shift_id, PDO::PARAM_INT);
            $pdpstm1->execute();
            echo "Success";
    }

    private function _showDay($cellNumber){


        /*
         * echo $this->currentRowCount;
         * if(isset($this->currentShifts ) && $this->currentRowCount > 0) {
         * echo intval($this->currentShifts[0]['day(StartTime)']);
         * }
        */


        if($this->currentDay==0){

            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));

            if(intval($cellNumber) == intval($firstDayOfTheWeek)){

                $this->currentDay=1;

            }
        }

        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){

            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));

            $cellContent = $this->currentDay;

            if(isset($this->currentShifts ) && $this->currentRowCount > 0) {
                foreach ($this->currentShifts as $shift) {
                    if(intval($shift['day(StartTime)']) == $this->currentDay) {
                        if(strval($shift['ShiftStatus']) == 'N') {
                            $cellContent .= '<button type="button" class="btn btn-outline-info btn-sm pull-right" data-toggle="modal" data-target="#updateStatus">'. $this->shiftstaus[$shift['ShiftStatus']].'&nbsp</button>';

                            $cellContent .= '<div class="modal fade bd-example-modal-sm" id="updateStatus" tabindex="-1" role="dialog"
                                             aria-labelledby="updateStatusLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="updateStatusLabel">
                                                            Confirm your shift
                                                        </h4>
                                                    </div>
                                    
                                                    <!-- Modal Body -->
                                                    <div class="modal-body">
                                    
                                                        <form role="form" action="employee-dashboard.php" method="post">
                                                            <input type="radio" name="status" value="N" checked disabled/>
                                                            <label for="status">New Shift</label>&nbsp
                                                            <input type="radio" name="status" value="A"/>
                                                            <label for="status">Accept</label>&nbsp
                                                            <input type="radio" name="status" value="R"/>
                                                            <label for="status">Reject</label>&nbsp
                                                            <input type="number" name="shift_id" value="'.$shift['ShiftId'].'" hidden></br></br>
                                                            <button type="submit" class="btn btn-success btn-sm">Submit</button>
                                                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                        } else if(strval($shift['ShiftStatus']) == 'A') {
                            $cellContent .= '<button type="button" class="btn btn-outline-primary btn-sm pull-right disabled">'. $this->shiftstaus[$shift['ShiftStatus']].'&nbsp</button>';
                        } else if(strval($shift['ShiftStatus']) == 'R') {
                            $cellContent .= '<button type="button" class="btn btn-outline-danger btn-sm pull-right disabled">'. $this->shiftstaus[$shift['ShiftStatus']].'&nbsp</button>';
                        } else if(strval($shift['ShiftStatus']) == 'D') {
                            $cellContent .= '<button type="button" class="btn btn-outline-success btn-sm pull-right disabled">'. $this->shiftstaus[$shift['ShiftStatus']].'&nbsp</button>';
                        } else {
                            $cellContent .= '<button type="button" class="btn btn-outline-secondary btn-sm pull-right disabled">'. $this->shiftstaus[$shift['ShiftStatus']].'&nbsp</button>';
                        }
                        //unset($this->currentShifts[0]);
                    }
                }
            }

            $this->currentDay++;

        }else{

            $this->currentDate =null;

            $cellContent=null;
        }


        return '<td style="height:100px;width:200px" id="td-'.$this->currentDate.'" class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
            ($cellContent==null?'mask':'').'">'.$cellContent.'</td>';
    }

    /**
     * create navigation
     */
    private function _createNavi(){

        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;

        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;

        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;

        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;

        return '<th colspan="3" style="text-align: left">
            <a href="'.$this->naviHref.'?month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">Prev</a></th>'.
            '<th style="text-align: center">'.date('M Y',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</th>'.
            '<th colspan="3" style="text-align: right"><a href="'.$this->naviHref.'?month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">Next</a></th>';
    }

    /**
     * create calendar week labels
     */
    private function _createLabels(){

        $content='';

        foreach($this->dayLabels as $index=>$label){

            $content.='<th>'.$label.'</th>';

        }
        return $content;
    }



    /**
     * calculate number of weeks in a particular month
     */
    private function _weeksInMonth($month=null,$year=null){

        if( null==($year) ) {
            $year =  date("Y",time());
        }

        if(null==($month)) {
            $month = date("m",time());
        }

        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);

        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);

        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));

        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));

        if($monthEndingDay<$monthStartDay){

            $numOfweeks++;

        }

        return $numOfweeks;
    }

    /**
     * calculate number of days in a particular month
     */
    private function _daysInMonth($month=null,$year=null){

        if(null==($year))
            $year =  date("Y",time());

        if(null==($month))
            $month = date("m",time());

        return date('t',strtotime($year.'-'.$month.'-01'));
    }

}
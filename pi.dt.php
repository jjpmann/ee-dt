<?php

class Dt
{

    var $_dt;
    var $_dp;
    var $_format;
    var $_ee_format = true;
    // -----
    var $_d=0; // add day value
    var $_m=0; // add month value
    var $_y=0; // add year value
    // -----
    var $_h=0; // add hour value
    var $_i=0; // add minute value
    var $_s=0; // add second value
    // ----
    var $return_data = null;

    /**
     * Construct
     *
     **/
    function __construct()
    {

        $this->_format = (ee()->TMPL->fetch_param('format') ? ee()->TMPL->fetch_param('format') : '%m/%d/%y');

        $this->_ee_format = (ee()->TMPL->fetch_param('ee_format') == "false" ? false : true);
        
        // set month . day . year   
        $this->_d = (ee()->TMPL->fetch_param('day') ? ee()->TMPL->fetch_param('day')    : 0);
        $this->_m = (ee()->TMPL->fetch_param('month')   ? ee()->TMPL->fetch_param('month')  : 0);
        $this->_y = (ee()->TMPL->fetch_param('year')    ? ee()->TMPL->fetch_param('year')   : 0);

        // set hour . minute . second
        $this->_h = (ee()->TMPL->fetch_param('hour')    ? ee()->TMPL->fetch_param('hour')   : 0);
        $this->_i = (ee()->TMPL->fetch_param('minute')  ? ee()->TMPL->fetch_param('minute'): 0);
        $this->_s = (ee()->TMPL->fetch_param('second')  ? ee()->TMPL->fetch_param('second'): 0);

        // localize date
        $this->localize = (ee()->TMPL->fetch_param('localize') == "false" ? false : true);
        $this->offset   = strtotime(gmdate("M d Y H:i:s")) - strtotime(date("M d Y H:i:s"));

        $dt = (ee()->TMPL->fetch_param('set') ? ee()->TMPL->fetch_param('set') : '');

        $this->_set($dt);

        $this->_add();

        if( ! $this->localize )
        {   
        //  $this->_dt += $this->offset;
        }

        $this->return_data = $this->_return();
    }

    
    /**
     * return formater
     * 
     * @return string
     **/
    function _return()
    {
        if ($this->_ee_format == true)
        {
            return ee()->localize->format_date($this->_format,$this->_dt);
        }

        return strftime($this->_format,$this->_dt);
        

    }

    /**
     * convert to timestamp and set variable $this->_dt
     *
     **/
    function _set($dt="")
    {

        $oldStamp = $this->_dt;

        if ($dt=="" || $dt=="//")
            $this->_dt=time();
        else
            $this->_dt = $this->_parseDate($dt);

        if ($oldStamp != $this->_dt)
        {
            $this->_dp = getdate($this->_dt);
        }
        return $this;
    }

    /**
     * parse included date
     *
     **/
    function _parseDate($dt="")
    {
        $ts = 0; // timestamp of parsed date
            
        if(gettype($dt) == 'string')    $ts=strtotime($dt);
        if(gettype($dt) == 'integer')   $ts=$dt;
        
        return $ts; 
    }

    /**
     * add to date
     *
     **/
    function _add()
    {
            $year   = $this->_dp['year'];
            $month  = $this->_dp['mon'];
            $day    = $this->_dp['mday'];

            $hour   = $this->_dp['hours'];
            $min    = $this->_dp['minutes'];
            $sec    = $this->_dp['seconds'];
            
        
            $this->_set(mktime(
                $hour+$this->_h,
                $min+$this->_i,
                $sec+$this->_s,
                $month+$this->_m,
                $day+$this->_d, 
                $year+$this->_y
                ));
            
            $this->return_data = $this->_return();
    }

    /**
     * Used as tag pair
     *
     **/
    function wrap()
    {

        $vars = array(
            'year'  => $this->_dp['year'],
            'month' => $this->_dp['mon'],
            'day'   => $this->_dp['mday'],
            'dt'    => $this->_dt,
            'dt_ee' => ee()->localize->format_date('%Y-%m-%d %H:%i',$this->_dt)
            );
        
        // $_return = ee()->TMPL->parse_variables( ee()->TMPL->tagdata, array($vars) );
        $_return = ee()->TMPL->parse_variables_row(ee()->TMPL->tagdata, $vars); 

        $_return = str_replace('dt_no_results', 'no_results', $_return);

        return $_return;

    }

    /**
     * return the date 
     *
     **/
    function time()
    {
        return $this->_dt;
    }
    
    /**
     * return only the year
     *
     **/
    function year()
    {
            return $this->_dp['year'];
    }

    /**
     * return only the month
     *
     **/
    function month()
    {
            return $this->_dp['mon'];
    }

    /**
     * return only the day
     *
     **/
    function day()
    {
            return $this->_dp['mday'];
    }
}


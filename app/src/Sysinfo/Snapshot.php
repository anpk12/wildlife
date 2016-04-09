<?php

namespace Anpk12\Sysinfo;

class Snapshot
{
    function __construct()
    {
        $this->readLoadAvg();
        $this->readMeminfo();
    }

    private $loadavgData = [];
    private function readLoadAvg()
    {
        $f = fopen("/proc/loadavg", "r");
        if ( !$f )
            throw new Exception("failed to read loadavg");
        if ( ($str = fgets($f)) != FALSE )
        {
            $this->loadavgData = explode(" ", $str);
            unset($this->loadavgData[3]);
            unset($this->loadavgData[4]);
        }
        fclose($f);
    }

    public function loadavg()
    {
        return $this->loadavgData;
    }

    private $meminfoData = [];
    private function readMeminfo()
    {
        $f = fopen("/proc/meminfo", "r");
        $this->meminfoData = [];
        if ( !$f )
            throw new Exception("failed to read meminfo");
        while ( ($str = fgets($f)) != FALSE )
        {
            $numMatches = preg_match_all(
            "/([[:alpha:]()_0-9]+):\s+([0-9]+)(?:\s([[:alpha:]]+)){0,1}/",
                $str, $entry, PREG_SPLIT_DELIM_CAPTURE);
            //echo var_dump($entry);
            if ( $numMatches > 0 )
            {
                $key = $entry[0][1];
                $newEntry = array('value' => $entry[0][2]);
                if ( isset($entry[0][3]) )
                {
                    $newEntry['unit'] = $entry[0][3];
                }
                $this->meminfoData[$key] = $newEntry;
            }
        }
        fclose($f);
    }

    /**
    Return all info from /proc/meminfo
    */
    public function meminfo()
    {
        return $this->meminfoData;
    }

    public function memTotal()
    {
        return $this->meminfoData['MemTotal'];
    }

    public function memAvailable()
    {
        return  $this->meminfoData['MemAvailable'];
    }

    public function htmlReport($summary=false)
    {
        $report = "<h2>Host system stats</h2>";
        $report .= "<h3>Memory</h3>";
        if ( $summary == true )
        {
            $mema = $this->memAvailable();
            $memt = $this->memTotal();
            $report .= "<p><strong>".entryStr($mema)."</strong> available
                out of a total of <strong>".entryStr($memt)."</strong></p>";
        } else
        {
            $report .= $this->memHtmlReport();
        }

        $report .= "<h3>Load</h3>";
        $loadavg = $this->loadavg();
        $report .= "<p>Average number of jobs in run queue or 
            waiting for disk I/O the last 1, 5, and 15 minutes: <strong>"
            .$loadavg[0]."</strong>, <strong>".$loadavg[1]."</strong>, <strong>".$loadavg[2]."</strong></p>";

        return $report;
    }
    public function memHtmlReport()
    {
        $mem = $this->meminfo();

        $html = '<table>';
        foreach ( $mem as $key => $entry )
        {
            $html .= '<tr>';
            $html .= '<td class="sysinfo_key">'.$key.
                '</td><td class="sysinfo_value">'.$entry['value'] .'</td>';
            if ( isset($entry['unit']) )
            {
                $html .= '<td class="sysinfo_unit">'.$entry['unit'].'</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</table>';

        return $html;
    }


};

function entryStr($entry)
{
    return $entry['value'].$entry['unit'];
}

?>

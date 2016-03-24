<?php
namespace Anpk12\MVC;

class CDatabaseModel implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    // Get name of data source (typically table name)
    // from class name
    public function getDataSource()
    {
        $s = implode('', array_slice(explode('\\', get_class($this)), -1));
        return strtolower($s);
    }

    public function findAll()
    {
        $dataSource = $this->getDataSource();
        $this->db->select()->from($dataSource);

        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }

    // Properties associated with the db table of the model
    // TODO use "whitelisting" (even if it has to be
    // implemented multiple times in derived classes)
    public function getProperties()
    {
        $props = get_object_vars($this);
        unset($props['di']);
        unset($props['db']);
        return $props;
    }
}

?>

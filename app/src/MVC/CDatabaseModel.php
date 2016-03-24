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

    public function find($id)
    {
        $dataSource = $this->getDataSource();
        $this->db->select()->from($dataSource)->where("id= ?");

        $this->db->execute([$id]);
        return $this->db->fetchInto($this);
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

    public function setProperties($props)
    {
        if ( !empty($props) )
        {
            foreach ( $props as $key => $val )
            {
                $this->$key = $val;
            }
        }
    }

    public function save($values = [])
    {
        $this->setProperties($values);
        $values = $this->getProperties();

        if ( isset($values['id']) )
        {
            return $this->update($values);
        } else
        {
            return $this->create($values);
        }
    }

    public function create($values)
    {
        $keys = array_keys($values);
        $values = array_values($values);

        $this->db->insert($this->getDataSource(), $keys);

        $res = $this->db->execute($values);

        $this->id = $this->db->lastInsertId();

        return $res;
    }

    public function delete($id)
    {
        $this->db->delete($this->getDataSource(), 'id = ?');

        return $this->db->execute([$id]);
    }

    public function update($values)
    {
        $keys = array_keys($values);
        $values = array_values($values);

        unset($keys['id']);
        $values[] = $this->id;

        $this->db->update($this->getDataSource(), $keys, "id = ?");
        
        return $this->db->execute($values);
    }
}

?>

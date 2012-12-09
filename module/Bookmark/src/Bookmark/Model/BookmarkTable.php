<?php
namespace Bookmark\Model;

use Zend\Db\TableGateway\TableGateway;

class BookmarkTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getBookmark($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveBookmark(Bookmark $bookmark)
    {
        $data = array(
            'link'         => $bookmark->link,
            'title'        => $bookmark->title,
            'description'  => $bookmark->description,
        );

        $id = (int)$bookmark->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getBookmark($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteBookmark($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}
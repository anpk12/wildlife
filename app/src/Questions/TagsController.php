<?php

namespace Anpk12\Questions;

class TagsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    public function initialize()
    {
        $this->tags = new \Anpk12\Questions\Tag();
        $this->tags->setDI($this->di);

        $this->assocs = new \Anpk12\Questions\QuestionTagAssociation();
        $this->assocs->setDI($this->di);
    }

    public function setupAction()
    {
        $this->theme->setTitle('setup tags');
        $this->db->dropTableIfExists('tag')->execute();

        $this->db->createTable(
            'tag',
            [
                'id' => ['integer',
                         'primary key',
                         'not null',
                         'auto_increment'],
                'name' => ['varchar(80)'],
                'description' => ['varchar(512)'],
            ]
        )->execute();

        $this->db->insert('tag',
                         ['name', 'description']);
        $this->db->execute(['tag-yeah', 'this is a sample tag']);
        $this->db->execute(['tag-nope', 'this is just a tag used for testing']);

        $this->db->dropTableIfExists('questiontagassociation')->execute();
        $this->db->createTable(
            'questiontagassociation',
            [
                'id' => ['integer',
                         'primary key',
                         'not null',
                         'auto_increment'],
                'questionid' => ['integer'],
                'tagid' => ['integer'],
                'created' => ['datetime']
            ]
        )->execute();

        $now = gmdate('Y-m-d H:i:s');
        $this->db->insert('questiontagassociation',
                         ['questionid', 'tagid', 'created']);
        $this->db->execute(['1', '1', $now]);
        $this->db->execute(['1', '2', $now]);
    }

    public function listAction()
    {
        $tags = $this->tags->findAll();

        $this->theme->setTitle("Tags");
        $this->views->add('tags/list', // TODO impl this view
                          ['tags' => $tags,
                           'title' => 'Tags']);
    }

    /*
    public function viewAction($id)
    {
    }
    */

    public function getTagsForQuestionAction($questionId)
    {
        // TODO can this be done in a single query...?
        $assocs = $this->assocs->query()
            ->where('questionid is ' . $questionId)
            ->execute();

        echo 'count assocs: ' . count($assocs);
        $tags = [];
        foreach ( $assocs as $assoc )
        {
            $tags[] = $this->tags->query()
                ->where('id is ' . $assoc->tagid)
                ->execute()[0];
        }
        echo 'tags is: ' . var_dump($tags);

        return $tags;
    }
}


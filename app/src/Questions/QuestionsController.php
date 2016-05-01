<?php

namespace Anpk12\Questions;

class QuestionsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    public function initialize()
    {
        $this->questions = new \Anpk12\Questions\Question();
        $this->questions->setDI($this->di);
    }

    public function setupAction()
    {
        $this->theme->setTitle('setup questions');
        $this->db->dropTableIfExists('question')->execute();

        $this->db->createTable(
            'question',
            [
                'id' => ['integer',
                         'primary key',
                         'not null',
                         'auto_increment'],
                'topic' => ['varchar(80)'],
                'text' => ['varchar(1024)'],
                'userid' => ['integer'],
                'points' => ['integer'],
                'created' => ['datetime'],
                'updated' => ['datetime'],
            ]
        )->execute();

        $this->db->insert('question',
                         ['topic',
                          'text',
                          'userid',
                          'points',
                          'created',
                          'updated']);
        $now = gmdate('Y-m-d H:i:s');
        $this->db->execute(['First dumb question',
                           'Is this a stupid question?',
                           '3',
                           '0',
                           $now,
                           $now]);

        $this->db->execute(['Second dumb question',
                           'Is this too a stupid question?',
                           '3',
                           '0',
                           $now,
                           $now]);
    }

    public function listAction()
    {
        $questions = $this->questions->findAll();

        foreach ( $questions as $q )
        {
            $user = $this->dispatcher->forward([
                'controller' => 'users',
                'action'     => 'getUser',
                'params'     => ['id' => $q->userid]
            ]);
            $q->userAcronym = $user->acronym;
        }

        $this->theme->setTitle("Questions");
        $this->views->add('questions/list',
                          ['questions' => $questions,
                           'title' => 'Questions']);
    }
}


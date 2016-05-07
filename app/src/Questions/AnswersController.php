<?php

namespace Anpk12\Questions;

class AnswersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    public function initialize()
    {
        $this->answers = new \Anpk12\Questions\Answer();
        $this->answers->setDI($this->di);
    }

    public function setupAction()
    {
        $this->theme->setTitle('setup answers');
        $this->db->dropTableIfExists('answer')->execute();

        $this->db->createTable(
            'answer',
            [
                'id' => ['integer',
                         'primary key',
                         'not null',
                         'auto_increment'],
                'text' => ['varchar(1024)'],
                'userid' => ['integer'],
                'questionid' => ['integer'],
                'votes' => ['integer'],
                'created' => ['datetime'],
                'updated' => ['datetime'],
            ]
        )->execute();

        $this->db->insert('answer',
                         ['text',
                          'userid',
                          'questionid',
                          'votes',
                          'created',
                          'updated']);
        $now = gmdate('Y-m-d H:i:s');
        $this->db->execute(['Is this a stupid answer?',
                           '1',
                           '1',
                           '0',
                           $now,
                           $now]);
        $this->db->execute(['Is this also a stupid answer?',
                           '3',
                           '1',
                           '0',
                           $now,
                           $now]);
    }

    public function getAnswersForQuestionAction($questionId)
    {
        $answers = $this->answers->query()
            ->where('questionid is ' . $questionId)
            ->execute();
        return $answers;
    }

    public function getAnswersBy($userId)
    {
        if ( !isset($this->answers) )
            $this->initialize();

        $answers = $this->answers->query()
            ->where('userid is ' . $userId)
            ->execute();
        return $answers;
    }

    public function addAnswer($questionId, $answertext, $userId)
    {
        $now = gmdate('Y-m-d H:i:s');
        $res = $this->answers->save([
            'text' => $answertext,
            'userid' => $userId,
            'questionid' => $questionId,
            'votes' => 0,
            'created' => $now,
            'updated' => $now
        ]);

        return $res;
    }
}


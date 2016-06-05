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

    public function indexAction()
    {
        listAction();
    }

    /**
    @brief
    List questions in a compact view only including number
    of answers, topic, acronym of poster and datetime.

    This is typically forwarded from the frontcontroller or
    UsersController, or invoked directly by a client visiting
    'questions/list'.

    @param maxPosts
    Max number of questions to list (has no effect when userId != null).

    @param userId
    Limit questions listed to only those posted by userId.

    @param userAcronym
    Acronym of the user (this might actually be an XSS vulnerability :S).
    */
    public function listAction($maxPosts = null, $userId = null, $userAcronym = null)
    {
        $questions = [];
        if ( $userId == null )
        {
            $this->theme->setTitle("Questions");
            //$questions = $this->questions->findAll();
            $query = $this->questions->query()
                ->orderBy('created DESC');
            if ( $maxPosts != null )
            {
                $query->limit($maxPosts);
            }
            $questions = $query->execute();
        } else
        {
            $questions = $this->questions->query()
                ->where('userid is ' . $userId)
                ->execute();
        }

        foreach ( $questions as $q )
        {
            $user = $this->dispatcher->forward([
                'controller' => 'users',
                'action'     => 'getUser',
                'params'     => ['id' => $q->userid]
            ]);
            $q->userAcronym = $user->acronym;

            $answers = $this->dispatcher->forward([
                'controller' => 'answers',
                'action' => 'getAnswersForQuestion',
                'params' => ['questionId' => $q->id]
            ]);
            $q->numAnswers = count($answers);
        }

        $this->views->add('questions/list',
                          ['questions' => $questions,
                           'title' => 'Questions'],
                           'main');
    }

    /**
    Show a summary of the question with ids given by $ids.
    Used via dispatcher->forward from TagsController::showAction.
    */
    public function showIdsAction($ids)
    {
        $questions = [];

        $questions = $this->questions->findThese($ids);

        // Exact copy of snippet from listAction, TODO private utility
        foreach ( $questions as $q )
        {
            $user = $this->dispatcher->forward([
                'controller' => 'users',
                'action'     => 'getUser',
                'params'     => ['id' => $q->userid]
            ]);
            $q->userAcronym = $user->acronym;

            $answers = $this->dispatcher->forward([
                'controller' => 'answers',
                'action' => 'getAnswersForQuestion',
                'params' => ['questionId' => $q->id]
            ]);
            $q->numAnswers = count($answers);
        }

        $this->views->add('questions/list',
                          ['questions' => $questions,
                           'title' => 'Questions']);
    }

    public function answeredByAction($userId, $userAcronym)
    {
        // Get all answers by $userId
        $answers = $this->AnswersController->getAnswersBy($userId);

        $questions = [];
        foreach ( $answers as $a )
        {
            $q = $this->questions->find($a->questionid);
            if ( !isset($questions[$q->id]) )
            {
                $questions[$q->id] = $q;
                $questions[$q->id]->numAnswers = 1;
                $questions[$q->id]->userAcronym = ''; //'acronym_goes_here';
            } else
                $questions[$q->id]->numAnswers += 1;
        }
        $this->views->add('questions/list',
                          ['questions' => $questions,
                           'title' => 'Answered by ' . $userAcronym]);
    }

    /**
    Show all questions tagged by $tagId.
    */
    public function taggedAction($tagName)
    {
        $questions = $this->dispatcher->forward([
            'controller' => 'tags',
            'action' => 'show',
            'params' => ['tagName' => $tagName]
        ]);
    }

    public function viewAction($id)
    {
        $q = $this->questions->find($id);
        $answers = $this->dispatcher->forward([
            'controller' => 'answers',
            'action' => 'getAnswersForQuestion',
            'params' => ['questionId' => $id]
        ]);

        $asker = $this->dispatcher->forward([
            'controller' => 'users',
            'action'     => 'getUser',
            'params'     => ['id' => $q->userid]
        ]);
        $q->userAcronym = $asker->acronym;

        $tags = $this->dispatcher->forward([
            'controller' => 'tags',
            'action'     => 'getTagsForQuestion',
            'params'     => ['questionId' => $id]
        ]);
        $q->tags = $tags;

        $this->Comment2Controller->initialize();
        $q->comments = $this->Comment2Controller->getQuestionComments($id);

        foreach ( $answers as $a )
        {
            $answerer = $this->dispatcher->forward([
                'controller' => 'users',
                'action'     => 'getUser',
                'params'     => ['id' => $a->userid]
            ]);
            $a->userAcronym = $answerer->acronym;

            $a->comments =
                $this->Comment2Controller->getAnswerComments($a->id);
        }

        $this->theme->setTitle($q->topic);
        $this->views->add('questions/view',
                          ['question' => $q,
                           'answers' => $answers,
                           'title' => $q->topic]);
    }

    public function askAction()
    {
        $this->session();
        $this->theme->setTitle("Ask a question");

        $user = $this->di->dispatcher->forward([
            'controller' => 'users',
            'action'     => 'getLoggedInUser',
            'params'     => []
        ]);
        if ( $user == null )
        {
            $loginurl = $this->url->create('users/login');
            $this->response->redirect($loginurl);
            return;
        }

        $form = $this->di->form->create([], [
            'topic' => [
                'type'  => 'text',
                'label' => 'Topic:',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'question' => [
                'type'  => 'text',
                'label' => 'Question:',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'tags' => [
                'type'  => 'text',
                'label' => 'Tags:',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            
            'submit' => [
                'type' => 'submit',
                'callback' => [$this, 'onAskSubmit']
            ],
        ]);

        $form->check([$this, 'onAskSuccess'], [$this, 'onAskFail']);
        $this->di->views->add('default/page', [
            'title' => "Ask your question",
            'content' => $form->getHTML()
        ]);
    }

    public function onAskSubmit($form)
    {
        $user = $this->di->dispatcher->forward([
            'controller' => 'users',
            'action'     => 'getLoggedInUser',
            'params'     => []
        ]);
        if ( $user == null )
        {
            return false;
        }
        $now = gmdate('Y-m-d H:i:s');
        $res = $this->questions->save([
            'topic' => $form->Value('topic'),
            'text ' => $form->Value('question'),
            'userid' => $user[0],
            'points' => 0,
            'created' => $now,
            'updated' => $now
        ]);
        if ( $res == false )
        {
            return false;
        }

        $tagnames = explode(' ', $form->Value('tags'));
        $res = $this->di->dispatcher->forward([
            'controller' => 'tags',
            'action'     => 'addAssocs',
            'params'     => [
                'questionId' => $this->questions->id,
                'tagNames' => $tagnames
            ]
        ]);
        
        return $res;
    }

    public function onAskSuccess($form)
    {
        $url = $this->url->create('questions/view/' . $this->questions->id);
        $this->response->redirect($url);
    }

    public function onAskFail($form)
    {
        $form->AddOutput("<p><i>Question not registered</i></p>");
        $url = $this->di->request->getCurrentUrl();
        $this->response->redirect($url);
    }

    public function answerAction($questionId)
    {
        $this->session();
        $this->theme->setTitle("Answer a question");

        $user = $this->di->dispatcher->forward([
            'controller' => 'users',
            'action'     => 'getLoggedInUser',
            'params'     => []
        ]);
        if ( $user == null )
        {
            $loginurl = $this->url->create('users/login');
            $this->response->redirect($loginurl);
            return;
        }

        $form = $this->di->form->create([], [
            'answertext' => [
                'type'  => 'textarea',
                'label' => 'Answer:',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'questionid' => [
                'type'  => 'hidden',
                'value' => $questionId,
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'submit' => [
                'type' => 'submit',
                'callback' => [$this, 'onAnswerSubmit']
            ],
        ]);

        $form->check([$this, 'onAnswerSuccess'], [$this, 'onAnswerFail']);
        $this->di->views->add('default/page', [
            'title' => "Answer a question",
            'content' => $form->getHTML()
        ]);
    }

    public function onAnswerSubmit($form)
    {
        $user = $this->di->dispatcher->forward([
            'controller' => 'users',
            'action'     => 'getLoggedInUser',
            'params'     => []
        ]);
        if ( $user == null )
        {
            return false;
        }
        $this->AnswersController->initialize();
        $res = $this->AnswersController
            ->addAnswer($form->Value('questionid'),
                        $form->Value('answertext'),
                        $user[0]);
        return $res;
    }

    public function onAnswerSuccess($form)
    {
        $url = $this->url->create(
            'questions/view/' . $form->Value('questionid'));
        $this->response->redirect($url);
    }

    public function onAnswerFail($form)
    {
        $form->AddOutput("<p><i>Answer not registered</i></p>");
        $url = $this->di->request->getCurrentUrl();
        $this->response->redirect($url);
    }

    public function getQuestionsBy($userId)
    {
        if ( !isset($this->questions) )
            $this->initialize();

        $questions = $this->questions->query()
            ->where('userid is ' . $userId)
            ->execute();
        return $questions;
    }
}


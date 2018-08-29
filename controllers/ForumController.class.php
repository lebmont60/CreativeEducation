<?php
    class ForumController
    {
        public function indexAction($params)
        {
            $v = new View("front-forum", "front");
        }

        public function addThreadAction($params)
        {
            /*récupération des variables POST*/
            
            //->titre du sujet
            $title = $params['POST'][0];
            //->id du créateur
            $creatorId = $params['POST'][1];
            //->contenu du premier message
            $content = $params['POST'][2];
            //->date de création
            $creationDate = $params['POST'][3];
            //->id du thread
            $threadId = 1; //à récupérer depuis la bdd : max(id) + 1
            
            /*=-Déclaration + instanciation de l'objet et exécution de la méthode-=*/

            $forum = new Forum;

            $forum->setTitle($title);
            $forum->setCreatorId($creatorId);
            $forum->setCreationDate($creationDate);

            $forum->save();

            /*=-Ajout du premier message dans le thread lors de sa création-=*/

            $this->addMessageAction([$creatorId, $content, $creationDate, $threadId]);
        }

        public function addMessageAction($params)
        {
            //ajout message directement depuis le thread
            if(isset($params['POST']))
            {
                $creatorId = $params['POST'][0];
                $content = $params['POST'][1];
                $creationDate = $params['POST'][2];
                $threadId = $params['POST'][3];
            }
            //ajout du premier message via création thread
            else
            {
                $creatorId = $params[0];
                $content = $params[1];
                $creationDate = $params[2];
                $threadId = $params[3];
            }

            $message = new Message;

            $message->setThreadId($threadId);
            $message->setContent($content);
            $message->setCreationDate($creationDate);
            $message->setCreatorId($creatorId);

            $message->save();
        }

        public function addCategoryAction($params)
        {
            /*récupération des variables POST*/
            
            //->titre de la catégorie
            $title = $params['POST'][0];
            //->id de la catégorie
            $categoryId = 1; //à récupérer depuis la bdd : max(id) + 1
            
            /*=-Déclaration + instanciation de l'objet et exécution de la méthode-=*/

            $category = new Forum;

            $category->setTitle($title);
            $category->setCreatorId($categoryId);

            $category->save();
        }

        public function updateThreadAction($params)
        {

        }

        public function updateMessageAction($params)
        {

        }

        public function updateCategoryAction($params)
        {
            /*récupération des variables POST*/
            
            //->titre de la catégorie
            $title = $params['POST'][0];
            //->id de la catégorie
            $categoryId = 1; //à récupérer depuis la bdd : max(id) + 1
            
            /*=-Déclaration + instanciation de l'objet et exécution de la méthode-=*/

            $category = new Forum;

            $category->setTitle($title);

            $category->save();
        }

        public function removeThreadAction($params)
        {
            /*récupération des variables POST*/
            //->id du sujet à supprimer
            $id = $params['POST'][0];

            $thread = new Thread;

            $thread->delete();
        }

        public function removeMessageAction($params)
        {
            /*récupération des variables POST*/
            //->id du message à supprimer
            $id = $params['POST'][0];

            $message = new Message;

            $message->delete();
        }

        public function removeCategoryAction($params)
        {
            /*récupération des variables POST*/
            //->id de la catégorie à supprimer
            $id = $params['POST'][0];

            $Category = new Category;

            $Category->delete();
        }
    }
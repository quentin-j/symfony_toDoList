<?php

namespace App\Controller;

use App\Model\TodoModel;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends AbstractController
{
    /**
     * Liste des tâches
     *
     * @Route("/todos", name="todo_list", methods={"GET"})
     */
    public function todoList() :Response 
    {
        $todos = TodoModel::findAll();

        return $this->render('todo/list.html.twig', [
            'todos' => $todos,
        ]);
    }

    /**
     * Affichage d'une tâche
     *
     * @Route("/todo/{id}", name="todo_show", methods={"GET"}, requirements={"id" = "\d+"})
     */
    public function todoShow($id) :Response
    {
        $todo = TodoModel::find($id);

        return $this->render('todo/single.html.twig', [
            'todo' => $todo
        ]);
    }

    /**
     * Changement de statut
     *
     * @Route("/todo/{id}/{status}", name="todo_set_status", methods={"GET"}, requirements={"id" = "\d+", "status" = "done|undone"})
     */
    public function todoSetStatus($id, $status) :Response
    {
        $jobDone = TodoModel::setStatus($id, $status);



        // on redirige vers la liste des tâches
        return $this->redirectToRoute('todo_list');
    }

    /**
     * Ajout d'une tâche
     *
     * @Route("/todo/add", name="todo_add", methods={"POST"})
     */
    public function todoAdd(Request $request) :Response
    {
        // Récupèrer le nom de la tâche
        $taskName = $request->request->get('task');
        // Créer une tâche portant ce nom
        TodoModel::add($taskName);
        // on redirige vers la list des tâches
        return $this->redirectToRoute('todo_list');
    }
}

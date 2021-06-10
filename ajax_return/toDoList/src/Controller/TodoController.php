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
        // la méthode find renvoie false si l'id ne correspond à aucune tâche
        $todo = TodoModel::find($id);

        if (false === $todo)
        {
            throw $this->createNotFoundException('La tâche n\'existe pas !');
        }

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
        // setStatus vérifie si la tâche existe
        $jobDone = TodoModel::setStatus($id, $status);

        if (false === $jobDone)
        {
            throw $this->createNotFoundException('La tâche dont vous voulez modifier le status n\'existe pas !');
        }

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

    /**
     * suppression d'une tâche
     *
     * @Route("/todo/delete", name="todo_delete", methods={"POST"})
     */
    public function todoDelete(Request $request) :Response
    {
        // Récupèrer l'id de la tâche
        $taskName = $request->request->get('delete');

        // supprimer la tâche portant ce nom
        $taskDelete = TodoModel::delete($taskName);

        // on redirige vers la list des tâches
        return $this->redirectToRoute('todo_list');
    }

        /**
     * Réinitialission des tâche
s     *
     * @Route("/todo/reset", name="todo_reset", methods={"GET"})
     */
    public function todoReset() :Response
    {
        // réinitialiser les tâches portant ce nom
        TodoModel::reset();

        // on redirige vers la list des tâches
        return $this->redirectToRoute('todo_list');
    }
}

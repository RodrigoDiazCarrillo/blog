<?php

namespace App\Controller\Amin;

use App\Entity\Comentario;
use App\Form\ComentarioType;
use App\Repository\ComentarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/amin/comentario")
 */
class ComentarioController extends AbstractController
{
    /**
     * @Route("/", name="app_amin_comentario_index", methods={"GET"})
     */
    public function index(ComentarioRepository $comentarioRepository): Response
    {
        return $this->render('amin/comentario/index.html.twig', [
            'comentarios' => $comentarioRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_amin_comentario_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ComentarioRepository $comentarioRepository): Response
    {
        $comentario = new Comentario();
        $form = $this->createForm(ComentarioType::class, $comentario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comentarioRepository->add($comentario, true);

            return $this->redirectToRoute('app_amin_comentario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('amin/comentario/new.html.twig', [
            'comentario' => $comentario,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_amin_comentario_show", methods={"GET"})
     */
    public function show(Comentario $comentario): Response
    {
        return $this->render('amin/comentario/show.html.twig', [
            'comentario' => $comentario,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_amin_comentario_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Comentario $comentario, ComentarioRepository $comentarioRepository): Response
    {
        $form = $this->createForm(ComentarioType::class, $comentario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comentarioRepository->add($comentario, true);

            return $this->redirectToRoute('app_amin_comentario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('amin/comentario/edit.html.twig', [
            'comentario' => $comentario,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_amin_comentario_delete", methods={"POST"})
     */
    public function delete(Request $request, Comentario $comentario, ComentarioRepository $comentarioRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comentario->getId(), $request->request->get('_token'))) {
            $comentarioRepository->remove($comentario, true);
        }

        return $this->redirectToRoute('app_amin_comentario_index', [], Response::HTTP_SEE_OTHER);
    }
}

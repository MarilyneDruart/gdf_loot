<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/admin/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_user_list", methods={"GET"})
     */
    public function list(UserRepository $userRepository): Response
    {
        return $this->render('back/user/list.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="app_admin_user_create", methods={"GET", "POST"})
     */
    public function create(Request $request, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // actuellement le mot de passe n'est pas haché dans le user
            // on récupère le service UserPasswordHasherInterface 
            // pour hasher le mot de passe à la mano
            $passwordClear = $user->getPassword();
            $hashedPassword = $passwordHasher->hashPassword($user, $passwordClear);
            $user->setPassword($hashedPassword);

            // cette méthode fait le persist et le flush !
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_admin_user_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/user/create.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_user_read", methods={"GET"})
     */
    public function read(User $user): Response
    {
        return $this->render('back/user/read.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/update", name="app_admin_user_update", methods={"GET", "POST"})
     */
    public function update(Request $request, Security $security, User $user, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $this->denyAccessUnlessGranted('ROLE_USER', $user);

        // USER_UPDATE
        // si l'utilisateur que l'on édite a le role manager ou admin
        $form = $this->createForm(RegistrationFormType::class, $user);
        // $form->remove('password');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // est ce qu'un mot de passe a été saisi

            $passwordClear = $form->get('plainPassword')->getData();
            if (! empty($passwordClear))
            {
                // si oui alors le hashé et le remplacer dans l'objet user
                $hashedPassword = $passwordHasher->hashPassword($user, $passwordClear);
                $user->setPassword($hashedPassword);
            }

            $userRepository->add($user, true);

            return $this->redirectToRoute('app_admin_user_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/user/update.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_admin_user_list', [], Response::HTTP_SEE_OTHER);
    }
}

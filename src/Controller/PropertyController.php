<?php
namespace App\Controller;


use App\Entity\Contact;
use App\Entity\Property;
use App\Entity\SearchProperty;
use App\Form\ContactType;
use App\Form\SearchPropertyType;
use App\Notification\ContactNotification;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/biens", name="property.index", options={"utf8": true})
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new SearchProperty();
        $form =$this->createForm(SearchPropertyType::class, $search
        );
        $form->handleRequest($request);

        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            12
        );

//        $property = new Property();
//        $property->setTitle('Mon premier bien')
//            ->setPrice(200000)
//            ->setRooms(4)
//            ->setBedrooms(3)
//            ->setDescription('Une petite description')
//            ->setSurface(60)
//            ->setFloor(4)
//            ->setHeat(1)
//            ->setCity('Montpellier')
//            ->setAddress('15 Boulevard Gambetta')
//            ->setPostalCode('34000');
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($property);
//        $em->flush();

//        $repository = $this->getDoctrine()->getRepository(Property::class);
//        dump($repository);

//        $property = $this->repository->findAllVisible();
//        dump($property);
//        kad radimo update i kad je object preko repo pokupljen samo uradit flush jer object je direkt tracke par em
//        $property[0]->setSold(true);
//        $this->em->flush();
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties'   => $properties,
            'form'         => $form->createView()
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @param string $slug
     * @param Request $request
     * @param ContactNotification $contactNotification
     * @return Response
     */
    public function show(Property $property, string $slug, Request $request, ContactNotification $contactNotification) : Response
    {
        if ($property->getSlug() !== $slug) {

            return $this->redirectToRoute('property.show', [
                'id'    => $property->getId(),
                'slug'  => $property->getSlug()
            ],301);
        }

        $contact = new Contact();
        $contact->setProperty($property);

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactNotification->notify($contact);
            $this->addFlash('success', 'Votre email a bien ete envoye');

            return $this->redirectToRoute('property.show', [
                'id'    => $property->getId(),
                'slug'  => $property->getSlug()
            ]);
        }

        return $this->render('property/show.html.twig', [
            'property'     => $property,
            'current_menu' => 'properties',
            'form'         => $form->createView()
        ]);
    }
}
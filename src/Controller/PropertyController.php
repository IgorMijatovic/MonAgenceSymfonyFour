<?php
namespace App\Controller;


use App\Entity\Property;
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
        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery(),
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
            'properties'   => $properties
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Property $property, string $slug) : Response
    {
        if ($property->getSlug() !== $slug) {

            return $this->redirectToRoute('property.show', [
                'id'    => $property->getId(),
                'slug'  => $property->getSlug()
            ],301);
        }
        return $this->render('property/show.html.twig', [
            'property'     => $property,
            'current_menu' => 'properties'
        ]);
    }
}
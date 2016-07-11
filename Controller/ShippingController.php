<?php

namespace Maven\Bundle\MagentoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

use Maven\Bundle\MagentoBundle\Entity\Shipping;

class ShippingController extends Controller
{
    /**
     * @Route("/shipping", name="maven_magento_bundle_shipping_index")
     * @AclAncestor("maven_magento_bundle_shipping_view")
     * @Template
     */
    public function indexAction()
    {
        return [
            'entity_class' => Shipping::class
        ];
    }

    /**
     * @Route("/shipping/view/{id}", name="maven_magento_bundle_shipping_view", requirements={"id"="\d+"}))
     * @Acl(
     *      id="maven_magento_bundle_shipping_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="OroCRMMagentoBundle:Customer"
     * )
     * @Template
     *
     * @param Shipping $shipping
     *
     * @return array
     */
    public function viewAction(Shipping $shipping)
    {
        return ['entity' => $shipping];
    }

    /**
     * @Route("/shipping/sync/{id}", name="maven_magento_bundle_shipping_sync", requirements={"id"="\d+"}))
     * @AclAncestor("maven_magento_bundle_shipping_view")
     * @param Shipping $shipping
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function syncAction(Shipping $shipping)
    {
        $this->get('maven_magento.shipping_handler')->handle($shipping);

        return $this->redirect($this->generateUrl('maven_magento_bundle_shipping_view', ['id' => $shipping->getId()]));
    }

    /**
     * @Route("/shipping/create", name = "maven_magento_create_shipment", options= {"expose"= true})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createShipmentMassAction(Request $request)
    {
        $response = $this->get('maven_magento.mass_action.create_shipment_handler')->handle($request);

        return new JsonResponse($response);
    }

    /**
     * @Route("/shipping/send", name="maven_magento_bundle_shipping_send")
     * @AclAncestor("maven_magento_bundle_shipping_view")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendShipment(Request $request)
    {
        $params = $request->request->all();
        $shipment = $this->get('doctrine.orm.default_entity_manager')
            ->getRepository(Shipping::class)
            ->findOneBy([
                'id' => $params['id']
            ]);

        $this->get('maven_magento.delivery_handler')->handle($shipment, $params['provider']);

        return $this->redirectToRoute('maven_magento_bundle_shipping_view', ['id' => $params['id']]);
    }

    /**
     * @Route(
     *     "/shipping/getProviders/{id}",
     *      name="maven_magento_bundle_shipping_get_providers",
     *      requirements={"id"="\d+"}
     *     )
     * @Template("MavenMagentoBundle:Shipping:providers.html.twig")
     * @param $id
     *
     * @return array
     */
    public function getShipmentProviders($id)
    {
        $providers = $this->get('maven_magento.delivery_handler')->getProvidersNames();

        return compact('providers', 'id');
    }
}

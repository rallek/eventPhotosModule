<?php
/**
 * EventPhotos.
 *
 * @copyright Ralf Koester (RK)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Ralf Koester <ralf@familie-koester.de>.
 * @link http://k62.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio 1.3.0 (https://modulestudio.de).
 */

namespace RK\EventPhotosModule\Container\Base;

use Symfony\Component\Routing\RouterInterface;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;
use Zikula\Core\Doctrine\EntityAccess;
use Zikula\Core\LinkContainer\LinkContainerInterface;
use Zikula\ExtensionsModule\Api\ApiInterface\VariableApiInterface;
use Zikula\PermissionsModule\Api\ApiInterface\PermissionApiInterface;
use RK\EventPhotosModule\Helper\ControllerHelper;

/**
 * This is the link container service implementation class.
 */
abstract class AbstractLinkContainer implements LinkContainerInterface
{
    use TranslatorTrait;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var PermissionApiInterface
     */
    protected $permissionApi;

    /**
     * @var VariableApiInterface
     */
    protected $variableApi;

    /**
     * @var ControllerHelper
     */
    protected $controllerHelper;

    /**
     * LinkContainer constructor.
     *
     * @param TranslatorInterface    $translator       Translator service instance
     * @param Routerinterface        $router           Router service instance
     * @param PermissionApiInterface $permissionApi    PermissionApi service instance
     * @param VariableApiInterface   $variableApi      VariableApi service instance
     * @param ControllerHelper       $controllerHelper ControllerHelper service instance
     */
    public function __construct(
        TranslatorInterface $translator,
        RouterInterface $router,
        PermissionApiInterface $permissionApi,
        VariableApiInterface $variableApi,
        ControllerHelper $controllerHelper
    ) {
        $this->setTranslator($translator);
        $this->router = $router;
        $this->permissionApi = $permissionApi;
        $this->variableApi = $variableApi;
        $this->controllerHelper = $controllerHelper;
    }

    /**
     * Sets the translator.
     *
     * @param TranslatorInterface $translator Translator service instance
     */
    public function setTranslator(/*TranslatorInterface */$translator)
    {
        $this->translator = $translator;
    }

    /**
     * Returns available header links.
     *
     * @param string $type The type to collect links for
     *
     * @return array List of header links
     */
    public function getLinks($type = LinkContainerInterface::TYPE_ADMIN)
    {
        $contextArgs = ['api' => 'linkContainer', 'action' => 'getLinks'];
        $allowedObjectTypes = $this->controllerHelper->getObjectTypes('api', $contextArgs);

        $permLevel = LinkContainerInterface::TYPE_ADMIN == $type ? ACCESS_ADMIN : ACCESS_READ;

        // Create an array of links to return
        $links = [];

        if (LinkContainerInterface::TYPE_ACCOUNT == $type) {
            if (!$this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_OVERVIEW)) {
                return $links;
            }

            if (true === $this->variableApi->get('RKEventPhotosModule', 'linkOwnAlbumsOnAccountPage', true)) {
                $objectType = 'album';
                if ($this->permissionApi->hasPermission($this->getBundleName() . ':' . ucfirst($objectType) . ':', '::', ACCESS_READ)) {
                    $links[] = [
                        'url' => $this->router->generate('rkeventphotosmodule_' . strtolower($objectType) . '_view', ['own' => 1]),
                        'text' => $this->__('My albums', 'rkeventphotosmodule'),
                        'icon' => 'list-alt'
                    ];
                }
            }

            if (true === $this->variableApi->get('RKEventPhotosModule', 'linkOwnAlbumItemsOnAccountPage', true)) {
                $objectType = 'albumItem';
                if ($this->permissionApi->hasPermission($this->getBundleName() . ':' . ucfirst($objectType) . ':', '::', ACCESS_READ)) {
                    $links[] = [
                        'url' => $this->router->generate('rkeventphotosmodule_' . strtolower($objectType) . '_view', ['own' => 1]),
                        'text' => $this->__('My album items', 'rkeventphotosmodule'),
                        'icon' => 'list-alt'
                    ];
                }
            }

            if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_ADMIN)) {
                $links[] = [
                    'url' => $this->router->generate('rkeventphotosmodule_album_adminindex'),
                    'text' => $this->__('Event photos Backend', 'rkeventphotosmodule'),
                    'icon' => 'wrench'
                ];
            }


            return $links;
        }

        $routeArea = LinkContainerInterface::TYPE_ADMIN == $type ? 'admin' : '';
        if (LinkContainerInterface::TYPE_ADMIN == $type) {
            if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_READ)) {
                $links[] = [
                    'url' => $this->router->generate('rkeventphotosmodule_album_index'),
                    'text' => $this->__('Frontend', 'rkeventphotosmodule'),
                    'title' => $this->__('Switch to user area.', 'rkeventphotosmodule'),
                    'icon' => 'home'
                ];
            }
        } else {
            if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_ADMIN)) {
                $links[] = [
                    'url' => $this->router->generate('rkeventphotosmodule_album_adminindex'),
                    'text' => $this->__('Backend', 'rkeventphotosmodule'),
                    'title' => $this->__('Switch to administration area.', 'rkeventphotosmodule'),
                    'icon' => 'wrench'
                ];
            }
        }
        
        if (in_array('album', $allowedObjectTypes)
            && $this->permissionApi->hasPermission($this->getBundleName() . ':Album:', '::', $permLevel)) {
            $links[] = [
                'url' => $this->router->generate('rkeventphotosmodule_album_' . $routeArea . 'view'),
                'text' => $this->__('Albums', 'rkeventphotosmodule'),
                'title' => $this->__('Albums list', 'rkeventphotosmodule')
            ];
        }
        if (in_array('albumItem', $allowedObjectTypes)
            && $this->permissionApi->hasPermission($this->getBundleName() . ':AlbumItem:', '::', $permLevel)) {
            $links[] = [
                'url' => $this->router->generate('rkeventphotosmodule_albumitem_' . $routeArea . 'view'),
                'text' => $this->__('Album items', 'rkeventphotosmodule'),
                'title' => $this->__('Album items list', 'rkeventphotosmodule')
            ];
        }
        if ($routeArea == 'admin' && $this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_ADMIN)) {
            $links[] = [
                'url' => $this->router->generate('rkeventphotosmodule_config_config'),
                'text' => $this->__('Configuration', 'rkeventphotosmodule'),
                'title' => $this->__('Manage settings for this application', 'rkeventphotosmodule'),
                'icon' => 'wrench'
            ];
        }

        return $links;
    }

    /**
     * Returns the name of the providing bundle.
     *
     * @return string The bundle name
     */
    public function getBundleName()
    {
        return 'RKEventPhotosModule';
    }
}
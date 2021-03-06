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

namespace RK\EventPhotosModule\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Zikula\Core\Doctrine\EntityAccess;
use RK\EventPhotosModule\Traits\StandardFieldsTrait;
use RK\EventPhotosModule\Validator\Constraints as EventPhotosAssert;

/**
 * Entity class that defines the entity structure and behaviours.
 *
 * This is the base entity class for album item entities.
 * The following annotation marks it as a mapped superclass so subclasses
 * inherit orm properties.
 *
 * @ORM\MappedSuperclass
 */
abstract class AbstractAlbumItemEntity extends EntityAccess implements Translatable
{
    /**
     * Hook standard fields behaviour embedding createdBy, updatedBy, createdDate, updatedDate fields.
     */
    use StandardFieldsTrait;

    /**
     * @var string The tablename this object maps to
     */
    protected $_objectType = 'albumItem';
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", unique=true)
     * @var integer $id
     */
    protected $id = 0;
    
    /**
     * the current workflow state
     *
     * @ORM\Column(length=20)
     * @Assert\NotBlank()
     * @EventPhotosAssert\ListEntry(entityName="albumItem", propertyName="workflowState", multiple=false)
     * @var string $workflowState
     */
    protected $workflowState = 'initial';
    
    /**
     * Image meta data array.
     *
     * @ORM\Column(type="array")
     * @Assert\Type(type="array")
     * @var array $imageMeta
     */
    protected $imageMeta = [];
    
    /**
     * There is no maximum for the image size. If images are to big a memory error might occur. The administrator can switch on automatic shrinking.
     *
     * @ORM\Column(length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="0", max="255")
     * @Assert\File(
     *    mimeTypes = {"image/*"}
     * )
     * @Assert\Image(
     * )
     * @var string $image
     */
    protected $image = null;
    
    /**
     * Full image path as url.
     *
     * @Assert\Type(type="string")
     * @var string $imageUrl
     */
    protected $imageUrl = '';
    
    /**
     * If blank the uploading user will get the copyright. If you want to overwrite please fill in this.
     *
     * @ORM\Column(length=255)
     * @Assert\NotNull()
     * @Assert\Length(min="0", max="255")
     * @var string $copyright
     */
    protected $copyright = '';
    
    /**
     * sometimes it is nice to give the image a title
     *
     * @Gedmo\Translatable
     * @ORM\Column(length=30)
     * @Assert\NotNull()
     * @Assert\Length(min="0", max="30")
     * @var string $imageTitle
     */
    protected $imageTitle = '';
    
    /**
     * You may want to tell a bit about the shooting. The exif parameters are visible in detail view of the image.
     *
     * @Gedmo\Translatable
     * @ORM\Column(type="text", length=200)
     * @Assert\NotNull()
     * @Assert\Length(min="0", max="200")
     * @var text $imageDescription
     */
    protected $imageDescription = '';
    
    
    /**
     * Used locale to override Translation listener's locale.
     * this is not a mapped field of entity metadata, just a simple property.
     *
     * @Assert\Locale()
     * @Gedmo\Locale
     * @var string $locale
     */
    protected $locale;
    
    /**
     * @ORM\OneToMany(targetEntity="\RK\EventPhotosModule\Entity\AlbumItemCategoryEntity", 
     *                mappedBy="entity", cascade={"all"}, 
     *                orphanRemoval=true)
     * @var \RK\EventPhotosModule\Entity\AlbumItemCategoryEntity
     */
    protected $categories = null;
    
    /**
     * Bidirectional - Many albumItems [album items] are linked by one album [album] (OWNING SIDE).
     *
     * @ORM\ManyToOne(targetEntity="RK\EventPhotosModule\Entity\AlbumEntity", inversedBy="albumItems")
     * @ORM\JoinTable(name="rk_event_album")
     * @Assert\Type(type="RK\EventPhotosModule\Entity\AlbumEntity")
     * @var \RK\EventPhotosModule\Entity\AlbumEntity $album
     */
    protected $album;
    
    
    /**
     * AlbumItemEntity constructor.
     *
     * Will not be called by Doctrine and can therefore be used
     * for own implementation purposes. It is also possible to add
     * arbitrary arguments as with every other class method.
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }
    
    /**
     * Returns the _object type.
     *
     * @return string
     */
    public function get_objectType()
    {
        return $this->_objectType;
    }
    
    /**
     * Sets the _object type.
     *
     * @param string $_objectType
     *
     * @return void
     */
    public function set_objectType($_objectType)
    {
        if ($this->_objectType != $_objectType) {
            $this->_objectType = $_objectType;
        }
    }
    
    
    /**
     * Returns the id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Sets the id.
     *
     * @param integer $id
     *
     * @return void
     */
    public function setId($id)
    {
        if (intval($this->id) !== intval($id)) {
            $this->id = intval($id);
        }
    }
    
    /**
     * Returns the workflow state.
     *
     * @return string
     */
    public function getWorkflowState()
    {
        return $this->workflowState;
    }
    
    /**
     * Sets the workflow state.
     *
     * @param string $workflowState
     *
     * @return void
     */
    public function setWorkflowState($workflowState)
    {
        if ($this->workflowState !== $workflowState) {
            $this->workflowState = isset($workflowState) ? $workflowState : '';
        }
    }
    
    /**
     * Returns the image.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
     * Sets the image.
     *
     * @param string $image
     *
     * @return void
     */
    public function setImage($image)
    {
        if ($this->image !== $image) {
            $this->image = isset($image) ? $image : '';
        }
    }
    
    /**
     * Returns the image url.
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }
    
    /**
     * Sets the image url.
     *
     * @param string $imageUrl
     *
     * @return void
     */
    public function setImageUrl($imageUrl)
    {
        if ($this->imageUrl !== $imageUrl) {
            $this->imageUrl = isset($imageUrl) ? $imageUrl : '';
        }
    }
    
    /**
     * Returns the image meta.
     *
     * @return array
     */
    public function getImageMeta()
    {
        return $this->imageMeta;
    }
    
    /**
     * Sets the image meta.
     *
     * @param array $imageMeta
     *
     * @return void
     */
    public function setImageMeta($imageMeta = [])
    {
        if ($this->imageMeta !== $imageMeta) {
            $this->imageMeta = isset($imageMeta) ? $imageMeta : '';
        }
    }
    
    /**
     * Returns the copyright.
     *
     * @return string
     */
    public function getCopyright()
    {
        return $this->copyright;
    }
    
    /**
     * Sets the copyright.
     *
     * @param string $copyright
     *
     * @return void
     */
    public function setCopyright($copyright)
    {
        if ($this->copyright !== $copyright) {
            $this->copyright = isset($copyright) ? $copyright : '';
        }
    }
    
    /**
     * Returns the image title.
     *
     * @return string
     */
    public function getImageTitle()
    {
        return $this->imageTitle;
    }
    
    /**
     * Sets the image title.
     *
     * @param string $imageTitle
     *
     * @return void
     */
    public function setImageTitle($imageTitle)
    {
        if ($this->imageTitle !== $imageTitle) {
            $this->imageTitle = isset($imageTitle) ? $imageTitle : '';
        }
    }
    
    /**
     * Returns the image description.
     *
     * @return text
     */
    public function getImageDescription()
    {
        return $this->imageDescription;
    }
    
    /**
     * Sets the image description.
     *
     * @param text $imageDescription
     *
     * @return void
     */
    public function setImageDescription($imageDescription)
    {
        if ($this->imageDescription !== $imageDescription) {
            $this->imageDescription = isset($imageDescription) ? $imageDescription : '';
        }
    }
    
    /**
     * Returns the locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
    
    /**
     * Sets the locale.
     *
     * @param string $locale
     *
     * @return void
     */
    public function setLocale($locale)
    {
        if ($this->locale != $locale) {
            $this->locale = $locale;
        }
    }
    
    /**
     * Returns the categories.
     *
     * @return ArrayCollection[]
     */
    public function getCategories()
    {
        return $this->categories;
    }
    
    
    /**
     * Sets the categories.
     *
     * @param ArrayCollection $categories List of categories
     *
     * @return void
     */
    public function setCategories(ArrayCollection $categories)
    {
        foreach ($this->categories as $category) {
            if (false === $key = $this->collectionContains($categories, $category)) {
                $this->categories->removeElement($category);
            } else {
                $categories->remove($key);
            }
        }
        foreach ($categories as $category) {
            $this->categories->add($category);
        }
    }
    
    /**
     * Checks if a collection contains an element based only on two criteria (categoryRegistryId, category).
     *
     * @param ArrayCollection $collection Given collection
     * @param \RK\EventPhotosModule\Entity\AlbumItemCategoryEntity $element Element to search for
     *
     * @return bool|int
     */
    private function collectionContains(ArrayCollection $collection, \RK\EventPhotosModule\Entity\AlbumItemCategoryEntity $element)
    {
        foreach ($collection as $key => $category) {
            /** @var \RK\EventPhotosModule\Entity\AlbumItemCategoryEntity $category */
            if ($category->getCategoryRegistryId() == $element->getCategoryRegistryId()
                && $category->getCategory() == $element->getCategory()
            ) {
                return $key;
            }
        }
    
        return false;
    }
    
    /**
     * Returns the album.
     *
     * @return \RK\EventPhotosModule\Entity\AlbumEntity
     */
    public function getAlbum()
    {
        return $this->album;
    }
    
    /**
     * Sets the album.
     *
     * @param \RK\EventPhotosModule\Entity\AlbumEntity $album
     *
     * @return void
     */
    public function setAlbum($album = null)
    {
        $this->album = $album;
    }
    
    
    
    /**
     * Creates url arguments array for easy creation of display urls.
     *
     * @return array List of resulting arguments
     */
    public function createUrlArgs()
    {
        return [
            'id' => $this->getId()
        ];
    }
    
    /**
     * Returns the primary key.
     *
     * @return integer The identifier
     */
    public function getKey()
    {
        return $this->getId();
    }
    
    /**
     * Determines whether this entity supports hook subscribers or not.
     *
     * @return boolean
     */
    public function supportsHookSubscribers()
    {
        return true;
    }
    
    /**
     * Return lower case name of multiple items needed for hook areas.
     *
     * @return string
     */
    public function getHookAreaPrefix()
    {
        return 'rkeventphotosmodule.ui_hooks.albumitems';
    }
    
    /**
     * Returns an array of all related objects that need to be persisted after clone.
     * 
     * @param array $objects Objects that are added to this array
     * 
     * @return array List of entity objects
     */
    public function getRelatedObjectsToPersist(&$objects = [])
    {
        return [];
    }
    
    /**
     * ToString interceptor implementation.
     * This method is useful for debugging purposes.
     *
     * @return string The output string for this entity
     */
    public function __toString()
    {
        return 'Album item ' . $this->getKey() . ': ' . $this->getCopyright();
    }
    
    /**
     * Clone interceptor implementation.
     * This method is for example called by the reuse functionality.
     * Performs a quite simple shallow copy.
     *
     * See also:
     * (1) http://docs.doctrine-project.org/en/latest/cookbook/implementing-wakeup-or-clone.html
     * (2) http://www.php.net/manual/en/language.oop5.cloning.php
     * (3) http://stackoverflow.com/questions/185934/how-do-i-create-a-copy-of-an-object-in-php
     */
    public function __clone()
    {
        // if the entity has no identity do nothing, do NOT throw an exception
        if (!$this->id) {
            return;
        }
    
        // otherwise proceed
    
        // unset identifier
        $this->setId(0);
    
        // reset workflow
        $this->setWorkflowState('initial');
    
        // reset upload fields
        $this->setImage(null);
        $this->setImageMeta([]);
        $this->setImageUrl('');
    
        $this->setCreatedBy(null);
        $this->setCreatedDate(null);
        $this->setUpdatedBy(null);
        $this->setUpdatedDate(null);
    
    
        // clone categories
        $categories = $this->categories;
        $this->categories = new ArrayCollection();
        foreach ($categories as $c) {
            $newCat = clone $c;
            $this->categories->add($newCat);
            $newCat->setEntity($this);
        }
    }
}

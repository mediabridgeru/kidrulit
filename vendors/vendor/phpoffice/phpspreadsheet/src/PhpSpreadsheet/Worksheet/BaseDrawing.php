<?php

namespace PhpOffice\PhpSpreadsheet\Worksheet;

use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;
use PhpOffice\PhpSpreadsheet\Exception as PhpSpreadsheetException;
use PhpOffice\PhpSpreadsheet\IComparable;

class BaseDrawing implements IComparable
{
    /**
     * Image counter.
     *
     * @var int
     */
    private static $imageCounter = 0;

    /**
     * Image index.
     *
     * @var int
     */
    private $imageIndex = 0;

    /**
     * Name.
     *
     * @var string
     */
    protected $name;

    /**
     * Description.
     *
     * @var string
     */
    protected $description;

    /**
     * Worksheet.
     *
     * @var null|Worksheet
     */
    protected $worksheet;

    /**
     * Coordinates.
     *
     * @var string
     */
    protected $coordinates;

    /**
     * Offset X.
     *
     * @var int
     */
    protected $offsetX;

    /**
     * Offset Y.
     *
     * @var int
     */
    protected $offsetY;

    /**
     * Coordinates2.
     *
     * @var null|string
     */
    protected $coordinates2;

    /**
     * Offset X2.
     *
     * @var int
     */
    protected $offsetX2;

    /**
     * Offset Y2.
     *
     * @var int
     */
    protected $offsetY2;

    /**
     * Width.
     *
     * @var int
     */
    protected $width;

    /**
     * Height.
     *
     * @var int
     */
    protected $height;

    /**
     * Proportional resize.
     *
     * @var bool
     */
    protected $resizeProportional;

    /**
     * Rotation.
     *
     * @var int
     */
    protected $rotation;

    /**
     * Shadow.
     *
     * @var Drawing\Shadow
     */
    protected $shadow;

    /**
     * Image hyperlink.
     *
     * @var null|Hyperlink
     */
    private $hyperlink;

    /**
     * Image type.
     *
     * @var int
     */
    protected $type;

    /**
     * Create a new BaseDrawing.
     */
    public function __construct()
    {
        // Initialise values
        $this->name = '';
        $this->description = '';
        $this->worksheet = null;
        $this->coordinates = 'A1';
        $this->offsetX = 0;
        $this->offsetY = 0;
        $this->coordinates2 = null;
        $this->offsetX2 = 0;
        $this->offsetY2 = 0;
        $this->width = 0;
        $this->height = 0;
        $this->resizeProportional = true;
        $this->rotation = 0;
        $this->shadow = new Drawing\Shadow();
        $this->type = IMAGETYPE_UNKNOWN;

        // Set image index
        ++self::$imageCounter;
        $this->imageIndex = self::$imageCounter;
    }

    /**
     * Get image index.
     *
     * @return int
     */
    public function getImageIndex()
    {
        return $this->imageIndex;
    }

    /**
     * Get Name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set Description.
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get Worksheet.
     *
     * @return null|Worksheet
     */
    public function getWorksheet()
    {
        return $this->worksheet;
    }

    /**
     * Set Worksheet.
     *
     * @param bool $overrideOld If a Worksheet has already been assigned, overwrite it and remove image from old Worksheet?
     *
     * @return $this
     */
    public function setWorksheet(Worksheet $worksheet = null, $overrideOld = false)
    {
        if ($this->worksheet === null) {
            // Add drawing to \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
            $this->worksheet = $worksheet;
            $this->worksheet->getCell($this->coordinates);
            $this->worksheet->getDrawingCollection()->append($this);
        } else {
            if ($overrideOld) {
                // Remove drawing from old \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
                $iterator = $this->worksheet->getDrawingCollection()->getIterator();

                while ($iterator->valid()) {
                    if ($iterator->current()->getHashCode() === $this->getHashCode()) {
                        $this->worksheet->getDrawingCollection()->offsetUnset($iterator->key());
                        $this->worksheet = null;

                        break;
                    }
                }

                // Set new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
                $this->setWorksheet($worksheet);
            } else {
                throw new PhpSpreadsheetException('A Worksheet has already been assigned. Drawings can only exist on one \\PhpOffice\\PhpSpreadsheet\\Worksheet.');
            }
        }

        return $this;
    }

    /**
     * Get Coordinates.
     *
     * @return string
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Set Coordinates.
     *
     * @param string $coordinates eg: 'A1'
     *
     * @return $this
     */
    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    /**
     * Get OffsetX.
     *
     * @return int
     */
    public function getOffsetX()
    {
        return $this->offsetX;
    }

    /**
     * Set OffsetX.
     *
     * @param int $offsetX
     *
     * @return $this
     */
    public function setOffsetX($offsetX)
    {
        $this->offsetX = $offsetX;

        return $this;
    }

    /**
     * Get OffsetY.
     *
     * @return int
     */
    public function getOffsetY()
    {
        return $this->offsetY;
    }

    /**
     * Get Coordinates2.
     *
     * @return null|string
     */
    public function getCoordinates2()
    {
        return $this->coordinates2;
    }

    /**
     * Set Coordinates2.
     *
     * @param null|string $coordinates2 eg: 'A1'
     *
     * @return $this
     */
    public function setCoordinates2($coordinates2)
    {
        $this->coordinates2 = $coordinates2;

        return $this;
    }

    /**
     * Get OffsetX2.
     *
     * @return int
     */
    public function getOffsetX2()
    {
        return $this->offsetX2;
    }

    /**
     * Set OffsetX2.
     *
     * @param int $offsetX2
     *
     * @return $this
     */
    public function setOffsetX2($offsetX2)
    {
        $this->offsetX2 = $offsetX2;

        return $this;
    }

    /**
     * Get OffsetY2.
     *
     * @return int
     */
    public function getOffsetY2()
    {
        return $this->offsetY2;
    }

    /**
     * Set OffsetY2.
     *
     * @param int $offsetY2
     *
     * @return $this
     */
    public function setOffsetY2($offsetY2)
    {
        $this->offsetY2 = $offsetY2;

        return $this;
    }

    /**
     * Set OffsetY.
     *
     * @param int $offsetY
     *
     * @return $this
     */
    public function setOffsetY($offsetY)
    {
        $this->offsetY = $offsetY;

        return $this;
    }

    /**
     * Get Width.
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set Width.
     *
     * @param int $width
     *
     * @return $this
     */
    public function setWidth($width)
    {
        // Resize proportional?
        if ($this->resizeProportional && $width != 0) {
            $ratio = $this->height / ($this->width != 0 ? $this->width : 1);
            $this->height = (int) round($ratio * $width);
        }

        // Set width
        $this->width = $width;

        return $this;
    }

    /**
     * Get Height.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set Height.
     *
     * @param int $height
     *
     * @return $this
     */
    public function setHeight($height)
    {
        // Resize proportional?
        if ($this->resizeProportional && $height != 0) {
            $ratio = $this->width / ($this->height != 0 ? $this->height : 1);
            $this->width = (int) round($ratio * $height);
        }

        // Set height
        $this->height = $height;

        return $this;
    }

    /**
     * Set width and height with proportional resize.
     *
     * Example:
     * <code>
     * $objDrawing->setResizeProportional(true);
     * $objDrawing->setWidthAndHeight(160,120);
     * </code>
     *
     * @param int $width
     * @param int $height
     *
     * @return $this
     *
     * @author Vincent@luo MSN:kele_100@hotmail.com
     */
    public function setWidthAndHeight($width, $height)
    {
        $xratio = $width / ($this->width != 0 ? $this->width : 1);
        $yratio = $height / ($this->height != 0 ? $this->height : 1);
        if ($this->resizeProportional && !($width == 0 || $height == 0)) {
            if (($xratio * $this->height) < $height) {
                $this->height = (int) ceil($xratio * $this->height);
                $this->width = $width;
            } else {
                $this->width = (int) ceil($yratio * $this->width);
                $this->height = $height;
            }
        } else {
            $this->width = $width;
            $this->height = $height;
        }

        return $this;
    }

    /**
     * Get ResizeProportional.
     *
     * @return bool
     */
    public function getResizeProportional()
    {
        return $this->resizeProportional;
    }

    /**
     * Set ResizeProportional.
     *
     * @param bool $resizeProportional
     *
     * @return $this
     */
    public function setResizeProportional($resizeProportional)
    {
        $this->resizeProportional = $resizeProportional;

        return $this;
    }

    /**
     * Get Rotation.
     *
     * @return int
     */
    public function getRotation()
    {
        return $this->rotation;
    }

    /**
     * Set Rotation.
     *
     * @param int $rotation
     *
     * @return $this
     */
    public function setRotation($rotation)
    {
        $this->rotation = $rotation;

        return $this;
    }

    /**
     * Get Shadow.
     *
     * @return Drawing\Shadow
     */
    public function getShadow()
    {
        return $this->shadow;
    }

    /**
     * Set Shadow.
     *
     * @return $this
     */
    public function setShadow(Drawing\Shadow $shadow = null)
    {
        $this->shadow = $shadow;

        return $this;
    }

    /**
     * Get hash code.
     *
     * @return string Hash code
     */
    public function getHashCode()
    {
        return md5(
            $this->name .
            $this->description .
            $this->worksheet->getHashCode() .
            $this->coordinates .
            $this->offsetX .
            $this->offsetY .
            $this->coordinates2 .
            $this->offsetX2 .
            $this->offsetY2 .
            $this->width .
            $this->height .
            $this->rotation .
            $this->shadow->getHashCode() .
            __CLASS__
        );
    }

    /**
     * Implement PHP __clone to create a deep clone, not just a shallow copy.
     */
    public function __clone()
    {
        $vars = get_object_vars($this);
        foreach ($vars as $key => $value) {
            if ($key == 'worksheet') {
                $this->worksheet = null;
            } elseif (is_object($value)) {
                $this->$key = clone $value;
            } else {
                $this->$key = $value;
            }
        }
    }

    public function setHyperlink(Hyperlink $hyperlink = null)
    {
        $this->hyperlink = $hyperlink;
    }

    /**
     * @return null|Hyperlink
     */
    public function getHyperlink()
    {
        return $this->hyperlink;
    }

    /**
     * Set Fact Sizes and Type of Image.
     */
    protected function setSizesAndType(string $path)
    {
        if ($this->width == 0 && $this->height == 0 && $this->type == IMAGETYPE_UNKNOWN) {
            $imageData = getimagesize($path);

            if (is_array($imageData)) {
                $this->width = $imageData[0];
                $this->height = $imageData[1];
                $this->type = $imageData[2];
            }
        }
    }

    /**
     * Get Image Type.
     */
    public function getType()
    {
        return $this->type;
    }
}
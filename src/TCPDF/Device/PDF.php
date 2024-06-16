<?php

namespace Weirdo\TCPDF\Device;

use Org_Heigl\Ghostscript\Device\DeviceInterface;

class PDF implements DeviceInterface
{
    /**
     * @var string $device
     */
    private $device = 'pdfwrite';

    /**
     * Get the name of the device as Ghostscript expects it
     *
     * @return string
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * Set the device
     *
     * @param string  $device
     * @return PDF
     */
    public function setDevice($device)
    {
        $device = strtolower($device);
        $devices = [
            'pdfwrite',
        ];
        $this->device = 'pdfwrite';
        if (in_array($device, $devices)) {
            $this->device = $device;
        }

        return $this;
    }

    /**
     * Get the complete parameter string for this device
     *
     * @return string
     */
    public function getParameterString()
    {
        $string = ' -sDEVICE=' . $this->getDevice();
        if (('pdfwrite' === $this->getDevice())) {
            $string .= ' -dCompatibilityLevel=1.4 ';
        }

        return $string;
    }

    /**
     * Get the file ending
     *
     * @return string
     */
    public function getFileEnding()
    {
        return 'pdf';
    }
}

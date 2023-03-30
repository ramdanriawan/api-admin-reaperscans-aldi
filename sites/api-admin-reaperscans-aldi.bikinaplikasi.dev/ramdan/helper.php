<?php

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

function toIdTime(String $date): String
{

    return date('d-M-Y, H:i:s', strtotime($date)) . " WIB";
}

function toIdr(int $number): String
{
    
    return "Rp" . number_format($number, 0, ",", ".");
}


function qrCode(String $data)
{
    $writer = new PngWriter();

// Create QR code
    $qrcode = QrCode::create($data)
        ->setEncoding(new Encoding('UTF-8'))
        ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
        ->setSize(500)
        ->setMargin(10)
        ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
        ->setForegroundColor(new Color(0, 0, 0))
        ->setBackgroundColor(new Color(255, 255, 255));

// Create generic logo
    $logo = Logo::create(public_path('image/logo.png'))
        ->setResizeToWidth(50);

// Create generic label //
    $label = Label::create($data)
        ->setTextColor(new Color(255, 0, 0));

    $result = $writer->write($qrcode, $logo, $label);

    // Directly output the QR code
    header('Content-Type: ' . $result->getMimeType());
    return $result->getString();
}
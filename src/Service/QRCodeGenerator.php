<?php

namespace App\Service;

use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\Encoding\Encoding;
use App\Entity\Produit;
use Symfony\Component\Filesystem\Filesystem;

class QRCodeGenerator
{
    private $builder;
    private $filesystem;

    public function __construct(BuilderInterface $builder, Filesystem $filesystem)
    {
        $this->builder = $builder;
        $this->filesystem = $filesystem;
    }

    public function generateQRCode(Produit $produit): string
    {
        $strValue = (string) $produit->getPrix();
        $data = "";
        $nom = $produit->getNom();
        $value = $strValue ; 
        $description = $produit->getDescription() ;
        $category = $produit->getCategorie()->getNom() ;
        $data = "Nom: " . $nom . "\n" . "Value: " . $value . "DT". "\n" . "Description: " . $description . "\n" . "Category: " . $category;
        

        $qrCode = $this->builder
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->build();
        
        $qrName = $produit->getNom() . '.png';
        $qrPath = \dirname(__DIR__,2) . '/public/qrcode';
        
        // Check if the directory exists, if not, create it
        if (!$this->filesystem->exists($qrPath)) {
            $this->filesystem->mkdir($qrPath);
        }
        
        $qrCode->saveToFile($qrPath . $qrName);
        return $qrCode->getDataUri();
    }
}
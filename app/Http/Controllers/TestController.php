<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

class TestController extends Controller
{
    public function test(Request $request)
    {

        # instantiates a client
        $imageAnnotator = new ImageAnnotatorClient();

        # the name of the image file to annotate
        $fileName = $request->images;

        # prepare the image to be annotated
        $image = file_get_contents($fileName);

        # performs label detection on the image file
        $response = $imageAnnotator->documentTextDetection($image);
        $fulltext = $response->getFullTextAnnotation()->getText();
        $fulltext = str_replace("\n", "\r\n", $fulltext);

        $text = $response->getTextAnnotations();
        // dd($fulltext);
        return view('welcome')->withFulltext($fulltext);
    }
}

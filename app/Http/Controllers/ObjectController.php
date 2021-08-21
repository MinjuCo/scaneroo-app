<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aws\Rekognition\RekognitionClient;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Feature\Type;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ObjectController extends Controller
{
    public function scanObject(Request $request) 
    {
        //$img = $request->input('picture');
        $image = file_get_contents($request->file('picture'));
        
        /*
        $client = new RekognitionClient([
            'region' => config('aws.region'),
            'version' => config('aws.version'),
            'credentials' => config('aws.credentials'),
        ]);

        $result = $client->detectLabels([
            'Image' => [
                'Bytes' => file_get_contents(storage_path('pens.jpg')),
            ],
            'MaxLabels' => 5,
            'MinConfidence' => 50,
        ]);
        dd($result['Labels']);
        $resultCollection = collect($result['Labels']);
        $object = $resultCollection->map(function($item, $key){
            $label['name'] = $item['Name'];
            $label['confidence'] = $item['Confidence'];
            $label['parents_length'] = count($item['Parents']);

            return $label;
        })->sortByDesc('parents_length')->first();

        dd($object);
        */

        
        $imageAnnatorClient = new ImageAnnotatorClient([
            'credentials' => json_decode(file_get_contents(config('google.credentials')), true)
            ]);
        
        //$image = file_get_contents(storage_path('pen.png'));

        $features = [Type::OBJECT_LOCALIZATION];

        $response = $imageAnnatorClient->annotateImage($image,$features);
        
    
        $object = $response->getLocalizedObjectAnnotations()->offsetGet(0);
        
        return [
            'name' => 'the '.strtolower($object->getName()),
            'boundingPoly' => [
                [
                    'x' => $object->getBoundingPoly()->getNormalizedVertices()->offsetGet(0)->getX(), 
                    'y' => $object->getBoundingPoly()->getNormalizedVertices()->offsetGet(0)->getY()
                ],
                [
                    'x' => $object->getBoundingPoly()->getNormalizedVertices()->offsetGet(1)->getX(), 
                    'y' => $object->getBoundingPoly()->getNormalizedVertices()->offsetGet(1)->getY()
                ],
                [
                    'x' => $object->getBoundingPoly()->getNormalizedVertices()->offsetGet(2)->getX(), 
                    'y' => $object->getBoundingPoly()->getNormalizedVertices()->offsetGet(2)->getY()
                ],
                [
                    'x' => $object->getBoundingPoly()->getNormalizedVertices()->offsetGet(3)->getX(), 
                    'y' => $object->getBoundingPoly()->getNormalizedVertices()->offsetGet(3)->getY()
                ]
            ],
        ];
        
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeownerController extends Controller
{
    private $titlesPattern = '(Mr|Mister|Mrs|Ms|Miss|Dr|Prof|Sir|Madam|Lady)';

    public function index()
    {
        return view('homeowners.index');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $people = $this->parseCSV($file->getRealPath());

        return view('homeowners.index', compact('people'));
    }

    public function reset()
    {
        return view('homeowners.index');
    }

    private function parseCSV($filePath)
    {
        $people = [];
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                foreach ($data as $name) {
                    $people = array_merge($people, $this->parseName($name));
                }
            }
            fclose($handle);
        }
        return $people;
    }

    private function parseName($name)
    {
        $people = [];
        $name = str_replace(['and', '&'], ',', $name);
        $name = str_replace(['.'],'', $name);
        $names = explode(',', $name);

        //ONLY ONE NAME
        if (count($names) == 1) {
            $people = $this->processIndividualName($name);
        }

        //Multiple Names
        if (strpos($name, ',')) {

            // Title + Title + First Name OR initial + Last Name
            if (preg_match_all('/' . $this->titlesPattern . '\.? , ' . $this->titlesPattern . '\.? (\w+)?\.? (\w+(-\w+)?)/', $name, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $people[] = $this->createPersonArray($match[1], $match[3], $match[4]);
                    $people[] = $this->createPersonArray($match[2], null, $match[4]);
                }
            }
             //Mr and Mrs + Last Name 
             elseif (preg_match_all('/' . $this->titlesPattern . '\.? , ' . $this->titlesPattern . '\.? (\w+(-\w+)?)/', $name, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $people[] = $this->createPersonArray($match[1], null, $match[3]);
                    $people[] = $this->createPersonArray($match[2], null, $match[3]);
                }
            }

            else {
                // TWO or MORE names
                foreach ($names as $individualName) {
                    $individualName = trim($individualName);
                    $people = $this->processIndividualName($individualName);
                }
            }
        }

        return $people;
    }

    private function processIndividualName($name)
    {
        $people = [];

        // Title + First Name OR Initial + Last Name
        if (preg_match_all('/' . $this->titlesPattern . '\.? (\w+)?\.? (\w+(-\w+)?)/', $name, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
            $people[] = $this->createPersonArray($match[1], $match[2] ?? null, $match[3] ?? null);
            }
        }
        // Title + Last Name
        elseif (preg_match_all('/' . $this->titlesPattern . '\.? (\w+(-\w+)?)/', $name, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
            $people[] = $this->createPersonArray($match[1], null, $match[2] ?? null);
            }
        }

        return $people;
    }

    private function createPersonArray($title, $firstName, $lastName)
    {
        return [
            'title' => $title,
            'first_name' => $firstName && strlen($firstName) > 1 ? $firstName : null,
            'initial' => $firstName && strlen($firstName) == 1 ? $firstName : null,
            'last_name' => $lastName
        ];
    }
}

<?php
namespace HonorRoll;

/**
 * Class to read a CSV file.
 *
 * @author  Jeff Mattson <jeff@layer7web.com>
 */
class HonorRollCSV
{

    private $filePath;
    private $length;
    private $delimiter;
    private $colNames = array();

    private $csvDataArray = array();

    /**
     * The constructor.
     *
     * @param string $filePath   The file path to the CSV
     * @param int    $colNames   Column names, associative array key values.
     * @param int    $length     Must be longer than the longest line in the CSV
     * @param char   $delimiter  The character that separates the data.
     */
    public function __construct($filePath, $colNames, $length = 1000, $delimiter = ',')
    {
        $this->filePath  = $filePath;
        $this->length    = $length;
        $this->delimiter = $delimiter;
        $this->colNamses = $colNames;
    }

    /**
     * Get the data in an associative array.
     *
     * @uses  testFileExists()
     * @return array
     */
    public function getArray()
    {
        if ($this->testFileIsReadable($this->filePath)) {
            if (($handle = fopen($this->filePath, "r")) !== false) {
                $lineCount = 0;
                while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                    $x = 0;
                    foreach ($this->colNamses as $key => $value) {
                        $this->csvDataArray[$lineCount][$key] = $data[$x];
                        $x++;
                    }

                    // CSV line count
                    $lineCount++;
                }
                fclose($handle);
            }
            return $this->csvDataArray;
        } else {
            error_log("Honor Roll: CSV file doesn't exist or doesn't have read permission.", 0);
            return false;
        }
    }

    /**
     * Get the file path of this object.
     *
     * @return string the current file path.
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Test if the file exists and is readable
     *
     * @param  string $filePath path to file
     * @return boolean          Exists and is readable.
     */
    private function testFileIsReadable($filePath)
    {
        $fileReadable = is_readable($filePath);
        return $fileReadable;
    }
}

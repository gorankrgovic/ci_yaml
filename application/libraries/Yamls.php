<?php
/**
 * Yaml
 *
 * A simple CodeIgniter wrapper class for the Symfony2 Yaml component.
 *
 * @author     Goran Krgovic <goran@verteez.com>
 * @license    MIT License
 * @copyright  2015 Goran Krgovic
 */
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Dumper;


class Yamls {

    /**
     * Default extension for the Yaml files
     * @var string
     */
    public $ext = 'yml';

    /**
     * Final reside folder
     * @var string
     */
    public $reside_folder = 'yaml';

    /**
     * Main folder where your yaml files resides
     * @var string
     */
    public $main_folder = APPPATH;

    /**
     * Inline or not - for writing Yaml arrays
     * @see http://symfony.com/doc/current/components/yaml/introduction.html
     */
    public $inline = 2;


    /**
     * Constructor function
     * @param array $config
     */
    public function __construct( $config= array() ) {

        empty( $config ) OR $this->initialize( $config );

        log_message('info', 'Yamls Class Initialized');

    }


    /**
     * Initialize with new config values
     * @param $config
     * @return $this
     */
    public function initialize( $config ) {
        foreach ( $config as $key => $val )
        {
            if ( isset( $this->$key ) )
            {
                $this->$key = $val;
            }
        }

        return $this;
    }


    /**
     * Parse yaml file
     * @param $file
     * @return mixed
     */
    public function parse( $file ) {
        //prepare file path
        $file = $this->get_file_path( $file );

        if ( !is_file( $file ) ) {
            show_error('Yaml - Trying to parse an invalid file: '. $file);
        }

        $file = file_get_contents($file);
        //initialize Symfony2 Yaml parser
        $yaml = new Parser();
        return $yaml->parse($file);
    }

    /**
     * Write the Yaml file
     * @param $array
     * @param $file
     * @param bool $inline
     */
    public function write( $array, $file, $inline = false ) {
        //prepare file path
        $file = $this->get_file_path( $file );

        //dump the array
        $yaml = $this->dump($array, $inline);

        //write to file
        file_put_contents($file, $yaml);
    }

    /**
     * Dump the yaml array
     * @param $array
     * @param bool $inline
     * @return string
     */
    public function dump( $array, $inline = false ) {
        if ( $inline ) {
            $inline = 1;
        } else {
            $inline = $this->inline;
        }

        //initialize the array
        $dumper = new Dumper();
        //dump the array
        return $dumper->dump( $array, $inline );
    }

    /**
     * Get the file path helper
     * @param $file
     * @return string
     */
    private function get_file_path( $file ) {
        return $this->main_folder . '/' . $this->reside_folder . '/' . $file . '.' . $this->ext;
    }

}
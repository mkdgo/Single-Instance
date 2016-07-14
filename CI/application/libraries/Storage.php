<?php 
require realpath( dirname(__FILE__) . '/AWS/aws-autoloader.php' );

//require '/var/sites/e/ediface.org/public_html/school/CI/application/libraries/AWS/aws-autoloader.php';
use Aws\S3\S3Client;
// for ACL
use Aws\S3\Enum\Group;
use Aws\S3\Model\AcpBuilder;

class Storage {

    private $s3Client;
    private $bucket;
    private $prefix = 'ediface-';

    private function setBucket( $bucket ) {
        $this->bucket = $this->prefix . $bucket;        
    }

    public function __construct( $bucket = null ) {
        $this->s3Client = S3Client::factory(array(
//            'profile' => 'my_profile',
            'credentials' => array(
                'key'       => 'AKIAJGRJ4G5LT6MJ7UWQ',
                'secret'    => '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'
            ),
            'region'  => 'eu-central-1',
            'version' => 'latest',
            'http'    => [
                'verify' => false
            ]
        ));
        if( $bucket ) {
            $this->setBucket($bucket);
        } else {
            $this->bucket = null;
        }
    }

    public function createBucket( $bucket ) {
        if( $bucket == null ) {
            return false;
        } else {
            $this->setBucket($bucket);
        }
        try {
            $result = $this->s3Client->createBucket(array('Bucket' => $this->bucket));
        } catch (Aws\S3\Exception\S3Exception $e) {
            echo $e->getMessage();
        }
//        if( $result ) {
//            $this->setBucket($bucket);
//        }
        return $result;
    }

    public function listBuckets() {
        try {
            $result = $this->s3Client->listBuckets();
            foreach ($result['Buckets'] as $bucket) {
                $buckets[] = $bucket['Name'] . '-' . $bucket['CreationDate'];
            }
        } catch (Aws\S3\Exception\S3Exception $e) {
            echo $e->getMessage();
        }
        return $buckets;
    }

    public function deleteBucket() {
        // Delete the objects in the bucket before attempting to delete
        // the bucket
        $clear = new ClearBucket($this->s3Client, $this->bucket);
        $clear->clear();

        // Delete the bucket
        $this->s3Client->deleteBucket(array('Bucket' => $this->bucket));

        // Wait until the bucket is not accessible
        $client->waitUntil('BucketNotExists', array('Bucket' => $this->bucket));
    }

/*
    public function setBucket( $bucket ) {
        if( $bucket ) {
            $this->bucket = $bucket;
            return true;
        }
        return false;
    }
//*/
    public function uploadFile($source, $file_key, array $meta = null ) {
        if( $meta ) {
            $result = $this->s3Client->putObject(array(
                'Bucket' => $this->bucket,
                'Key'    => $file_key,
                'SourceFile' => $source,
                'Metadata'   => $meta
            ));
        } else {
            $result = $this->s3Client->putObject(array(
                'Bucket' => $this->bucket,
                'Key'    => $file_key,
                'SourceFile' => $source
            ));
        }
        // We can poll the object until it is accessible
/*
        $this->s3Client->waitUntil('ObjectExists', array(
            'Bucket' => $this->bucket,
            'Key'    => 'data_from_file.txt'
        ));*/
        // Access parts of the result object
        $result['Expiration'];
        $result['ServerSideEncryption'];
        $result['ETag'];
        $result['VersionId'];
        $result['RequestId'];

        // Get the URL the object can be downloaded from
        $result['ObjectURL'];
        return $result;
    }

    public function getFiles() {
        $iterator = $this->s3Client->getIterator('ListObjects', array(
            'Bucket' => $this->bucket
        ));

        foreach ($iterator as $object) {
            $list[]['key'] = $object['Key'];
            $list[]['url'] = $this->showFile($object['Key']);
        }
        return $list;
    }

    public function showFile($file_key) {
        // Get a command object from the client and pass in any options
        // available in the GetObject command (e.g. ResponseContentDisposition)
        $cmd = $this->s3Client->getCommand('GetObject', array(
            'Bucket' => $this->bucket,
            'Key' => $file_key
        ));

        // Create a signed URL from the command object that will last for
        // 2 minutes from the current time
        $request = $this->s3Client->createPresignedRequest($cmd, '+30 minutes');
        // Get the actual presigned-url
//echo '<pre>';var_dump( $request['Metadata'] );die;
        $presignedUrl = (string) $request->getUri();
        return $presignedUrl;
    }

    public function downloadFile($file_key) {
        // Register the stream wrapper from an S3Client object
        $this->s3Client->registerStreamWrapper();
        $file = 's3://'.$this->bucket.'/'.$file_key;
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }

    public function copyFile( $file_key, $new_file_key ) {
        $result = $this->s3Client->copyObject(array(
            'Bucket' => $this->bucket,
            'Key'    => $new_file_key,
            'CopySource' => "{$this->bucket}/{$file_key}"
        ));
        return $result;
    }

    public function saveFile() {
        $result = $client->getObject(array(
            'Bucket' => $this->bucket,
            'Key'    => 'data.txt',
            'SaveAs' => '/tmp/data.txt'
        ));

        // Contains an EntityBody that wraps a file resource of /tmp/data.txt
//        echo $result['Body']->getUri() . "\n";
        // > /tmp/data.txt
    }

    public function setACL() {

        $acp = AcpBuilder::newInstance()
            ->setOwner($myOwnerId)
            ->addGrantForEmail('READ', 'test@example.com')
            ->addGrantForUser('FULL_CONTROL', 'user-id')
            ->addGrantForGroup('READ', Group::AUTHENTICATED_USERS)
            ->build();

        $this->s3Client->putObject(array(
            'Bucket'     => $this->bucket,
            'Key'        => 'data.txt',
            'SourceFile' => '/path/to/data.txt',
            'ACP'        => $acp
        ));
    }

}

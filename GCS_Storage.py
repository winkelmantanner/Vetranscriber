import os

from google.cloud import storage

SHAMHACKS_STORAGE_BUCKET = 'shamhacks-storage'
DEMO_FILE = 'output.wav'
GOOGLE_URI_PREFIX = 'gs://'

class GCS_Storage():
    def __init__(self, bucket_name=SHAMHACKS_STORAGE_BUCKET):
        self._bucket_name = SHAMHACKS_STORAGE_BUCKET
        self._storage_client = storage.Client()

    def upload(self, source_file_name, destination_blob_name=None):
        """
        Upload file to a bucket.

        Returns uploaded file name (may be different from `source_file_name`)
        """

        if destination_blob_name is None:
            destination_blob_name = os.path.basename(source_file_name)

        suffix = '0'
        blobs = {blob.name: True for blob in self.get_blobs()}
        original_destination_blob_name = destination_blob_name

        while blobs.get(destination_blob_name) is not None:
            base, ext = os.path.splitext(original_destination_blob_name)
            suffix = str(int(suffix)+1)
            destination_blob_name = ''.join([base, suffix, ext])
        
        bucket = self._storage_client.get_bucket(self._bucket_name)
        blob = bucket.blob(destination_blob_name)

        blob.upload_from_filename(source_file_name)
        return os.path.join(GOOGLE_URI_PREFIX + self._bucket_name, destination_blob_name)

    def download(self, source_blob_name, destination_file_name):
        """Download blob from a bucket."""

        bucket = self._storage_client.get_bucket(self._bucket_name)
        blob = bucket.blob(source_blob_name)

        blob.download_to_filename(destination_file_name)

    def get_blobs(self):
        """Lists all the blobs in the bucket."""
        
        bucket = self._storage_client.get_bucket(self._bucket_name)
        blobs = bucket.list_blobs()
        return blobs

    def list_blobs(self):
        for blob in self.get_blobs():
            print(blob.name)


if __name__ == '__main__':
    gcs_storage = GCS_Storage()
    gcs_storage.list_blobs()
    print(gcs_storage.upload(DEMO_FILE))
    print(gcs_storage.upload(DEMO_FILE))
    gcs_storage.list_blobs()
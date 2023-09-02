# DICOM image viewer
1. To test the application, you need to login to the VPS:
ssh -Y ubuntu@51.195.202.88
Password - liliya123!

2. Navigate to /var/www/html/lyankova/dicom-image-viewer
3. Run docker ps and see if the image 'jodogne/orthanc-plugins:1.5.6' is running
If yes - proceed with step 4
If not - proceed with step 3.1

3.1. Run docker-compose up --build -d
Run docker ps and see if the container is running

4. Navigate to /var/www/html/lyankova/dicom-image-viewer/Viewers
Execute - yarn run dev:orthanc to build the dependencies for the OHIF viewer

5. To access the website, please go to http://51.195.202.88/lyankova/dicom-image-viewer/index.php
Username - test
Password - test

6. If you want to add images to the Orthanc server, click the 'Add images' button
To login to Orthanc:
Username - orthanc
Password - orthanc

7. Once the images are added, go back to the Viewer and click the 'Viewer' button
You may be asked to authenticate yourself againts Orthanc's database - input the same username and password as mentioned above for Orthanc.


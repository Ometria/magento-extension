Extension workflow
------------------

Before using the script on a system for the first time open the script and edit some variables, things like default paths are hardcoded but easy to change. Also you will need to have the mysql module available for the python version that you use to run the script.

1. Use `mktest.py` to create a local magento install (recent version best), install extension through git/modman using a link to local repo.
2. Work on the extension by editing files in your local git repo
3. Bump version number in Ometria_core.xml and /app/code/community/Ometria/Core/etc/config.xml
4. In local magento, go to System > Magento Connect > Package Extensions > Load Local Package and click on Ometria_Core
5. Release Info: Update version number, update notes
6. Save Data and Create Package. If there is an error "There was a problem saving package data", do a `chmod -R 0777` on the magento folder and/or clear the cache then try again.
7. (if me, in magento folder) `cp var/connect/Ometria_Core-x.x.x.tgz ~/magento/extension/package/connect/ && cp var/pear/Ometria_Core-x.x.x.tgz ~/magento/extension/package/pear/`
8. Test on another instance (v1.5 best) using a local package from var/connect. If you want to test on v1.4 install the extension manually from /var/pear. It may be useful to enable logging in magento and look in var/log/ometria.log
9. Commit your changes to the repo
10. Login to http://www.magentocommerce.com/magento-connect/ with als account
11. Go to My Account > Developers, select Edit on the extension, go to Versions and click Add new version
12. Fill version number, select stable stability, copy notes from before and select versions 1.4-latest
13. Continue to upload and choose the package from var/pear
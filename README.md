<h2 align="center"> Instagram Feed Magento </h2>

## How to install Instagram Feed extension for Magento 1.9
## 1° Download Files
- Add files public
 ![Screenshot 2022-02-14 140958](https://user-images.githubusercontent.com/69697560/153912567-f831fcaf-b219-4291-af3a-ec3e2e81173c.png)

 - System > Cache Management > Select All > Action = Refresh > Submit
 - Log Out
 - Login
## 2° To set up
 - CMS > Pages > Home > Design > Layout Update XML
 - Add code 

   ```xml
    <reference name="content">
    <block type="core/template" name="instagramwidget" template="instagramfeed/instagramwidget.phtml">
        <action method="setData"><name>limit</name><value>10</value></action>
        </block>   
    </reference>
    ```
 --------

## 3° [Create an App Facebook for Developers - Documentation](https://developers.facebook.com/docs/development/create-an-app/)
### Step 1:
- Create app from

    ![Create app](https://user-images.githubusercontent.com/69697560/153916671-543de2ce-a88d-4938-b977-0e4550641573.png)

- Enter the neccesary information to create app. Click on Create App ID:
 
 ### Step 2: 
- Settings > Basic > Add Platform

    ![Add Website](https://user-images.githubusercontent.com/69697560/153917207-489d8665-c319-458b-8efc-eb987ce53faf.png)

-  Add Website > Advanced 

- Site URL : Add url website > Save Changes

## step 3°:
- Add Product 

   - ![image](https://user-images.githubusercontent.com/69697560/153918007-89946c0d-0d64-4290-8753-95ad385a3b12.png)

   - ![image](https://user-images.githubusercontent.com/69697560/153918111-2babc758-c41d-4ea3-8233-96c4bcce8a70.png)

## step 4°:

- Go to Roles > roles. In the Instagram Tester field, choose Add Instagram Testers
    ![image](https://user-images.githubusercontent.com/69697560/153919241-7f70cf4a-346e-4dc0-957e-c32010665a8e.png)

- To add instagram tester, enter their username

    ![image](https://user-images.githubusercontent.com/69697560/153919724-0df652ab-05d6-4867-a15a-732c822a2151.png)
    - In the next step, login to the Instagram account that you want to add and click on the cogwheel icon and choose Apps and Websites
    ![image](https://user-images.githubusercontent.com/69697560/153919971-8472cafa-193f-4ed6-bfea-cbf77b092d9e.png)

    - Click on Tester Invites and Accept
    ![image](https://user-images.githubusercontent.com/69697560/153920234-14b0906d-e0be-478d-95f7-afdd14c3ed40.png)

## Step 5: 

- Go back to App, choose Instagram > Basic Display. In the User Token Generator field, click on Generate Token

 ![image](https://user-images.githubusercontent.com/69697560/153920498-d3caa6ba-57b2-4a76-b799-68e8d9b8255a.png)

- Display Instagram login requirement, enter your credential and click on Login
- Click on Authorize
- Display Instagram Access Token. Click on Copy

## Step 6: 
 - From the Admin Panel, go to System > Configuration > MAGESHOP > Instagram Feed. Gerenciar Token > Paste the token that you have just copied to User Token. > 	Atualizar > Save Config 

    ![image](https://user-images.githubusercontent.com/69697560/153921503-440fbb03-0bdb-4662-bb7a-0c9289d143c7.png)
 - Força atualização de imagens > Atualizar

    ![image](https://user-images.githubusercontent.com/69697560/153921609-5425dd74-ee6c-4822-b144-983cd1ebf35a.png)

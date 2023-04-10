# discussIt

A unique take on a discussion board website.

# Running our code

**Prerequisites:**

- Download & Install [Docker Desktop](https://www.docker.com/).
- At least 1.59 GB's of space locally in addition to the space required by Docker.
- Stable Internet Connection

Follow the following steps to run our website locally:

1. Clone the repository to our local machine.
2. Start Docker Desktop.
3. Open a new terminal window within the newly cloned repository folder.
4. Run `docker-compose up -d` within the terminal window. **Note:** depending on your internet speed, this may take anywhere from a few seconds to a few minutes. This step tells docker to download all the resources required to run the website on your local machine. When docker has successfully completed installing and started all required resouces, you should see something similar to this within your terminal window:

   ![](./started-state.png)

5. Congratulations! The website is now up and running! To access the website, open any web browser (excluding Safari) and navigate to the following links depending on where you want to go:

   a. You can access the website at `localhost` or `localhost/80:80`.
   b. You can access the database at `localhost:8080`. The credentials to login to the database are, **Server**: `discussIt-mysql`, Username: `discussIt`, & Password: `password`. These credentials may be changed in `docker-compose.yml`.

> **IMPORTANT**
> Upon first opening our website, there will be no user's or discussion's within our website due to the database being empty.
>
> If you wish to give yourself administrator permissions, after signing up, log in to the database. Then navigate to the `user` table and for the account you desire, change the value of `administratorPermissions` to `1`. **You will only need to do this for the first admin user.** Any subsequent updates can be made via the administrator portal.

This Cockpit CMS addon allows you to import data into your collections via an API, supporting JSON and CSV file formats.

> If you're looking for Cockpit V1 - you can checkout to [this commit](https://github.com/ronaldaug/import-collection/tree/ba7fcc72f99bd0adb2dfa0a6b06b538da75c7e0c)

**Important Notes:**

* This is **NOT** an official Cockpit CMS addon.
* Before importing with this addon, back up your `storage` folder.
* It cannot import relational field types.
* Much of the code is adapted from the official Cockpit core [here.](https://github.com/agentejo/cockpit/blob/b0a2350b099d686b81e9c1b48fffef8845b85939/modules/Collections/Controller/Import.php#L28)

## Installation

1.  Place `import-v2` folder into your Cockpit "addons" directory.
2.  Go to `/system/info` in your Cockpit backend, clear the cache, and refresh the page.

## API Usage

* **Method:** `POST`
* **Endpoint:** `/api/import`

## Parameters

| Parameter   | Type   | Description                                                                        |
| :---------- | :----- | :--------------------------------------------------------------------------------- |
| `entries`   | File   | The JSON or CSV file containing the data to import.                                |
| `collection`| String | The name of the target collection (must match the name in your Cockpit dashboard). |
| `user_id`   | String | The ID of the user to whom the imported entries will be assigned.                  |
| `api_key`   | String | Your Cockpit user API key (e.g., `USR-****`).                                      |

## Import Steps

1.  Copy the `import.html` file to the root directory of your Cockpit installation.
2.  Open `https://yourdomain.com/import.html` in your web browser.
3.  Complete the form fields and submit to import your data.
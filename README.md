# Cockpit CMS Addon - Import Collection Via Api

Cockpit addon that can import collections data via API. Only accept "json" and "csv" file type.

### Disclaimer 
> Most of the code are taken from Cockpit core code [here `import.php`](https://github.com/agentejo/cockpit/blob/b0a2350b099d686b81e9c1b48fffef8845b85939/modules/Collections/Controller/Import.php#L28). 

### This is NOT an official addon of Cockpit CMS.
### And not able to import "relational" field type.

--------

## Installation

- Add this repo ( `import-collection` ) folder inside "addons" folder

- Navigate to `/system/info` , clear cache and refresh the page.

--------

### API

- Method - `post`
- Route - `/api/import`

--------

### Parameters

| parameter  | type      | description      | 
| ---------- | --------- | ---------------- |
| entries    | file      | csv or json file |
| collection | string    | collection name, this must be the same with the collection name inside Cockpit dashboard |
| user_id | string    | The imported entries will be assigned to this user ID. |
| api_key | string    | USR-**** |

--------

### Step to import

- Copy `import.html` to root folder.
- Navigate to `https://yourdomain.com/import.html`
- Fill all the field and import


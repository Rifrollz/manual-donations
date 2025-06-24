<?php
class MD_GitHub_Updater
{
    private $plugin_file;
    private $plugin_data;
    private $basename;
    private $github_user = 'Rifrollz';
    private $github_repo = 'manual-donations';

    public function __construct($plugin_file)
    {
        $this->plugin_file = $plugin_file;
        $this->plugin_data = get_plugin_data($plugin_file);
        $this->basename = plugin_basename($plugin_file);

        add_filter('pre_set_site_transient_update_plugins', [$this, 'check_update']);
        add_filter('plugins_api', [$this, 'plugin_info'], 10, 3);
    }

    public function check_update($transient)
    {
        if (empty($transient->checked))
            return $transient;

        $remote = wp_remote_get("https://api.github.com/repos/{$this->github_user}/{$this->github_repo}/releases/latest");

        if (is_wp_error($remote))
            return $transient;

        $release = json_decode(wp_remote_retrieve_body($remote));
        if (!isset($release->tag_name))
            return $transient;

        $new_version = ltrim($release->tag_name, 'v');

        if (version_compare($new_version, $this->plugin_data['Version'], '>')) {
            $transient->response[$this->basename] = (object) [
                'slug' => $this->basename,
                'plugin' => $this->basename,
                'new_version' => $new_version,
                'url' => $this->plugin_data['PluginURI'],
                'package' => $release->zipball_url,
            ];
        }

        return $transient;
    }

    public function plugin_info($false, $action, $args)
    {
        if ($action !== 'plugin_information' || $args->slug !== $this->basename)
            return false;

        $remote = wp_remote_get("https://api.github.com/repos/{$this->github_user}/{$this->github_repo}/releases/latest");

        if (is_wp_error($remote))
            return false;

        $release = json_decode(wp_remote_retrieve_body($remote));

        return (object) [
            'name' => $this->plugin_data['Name'],
            'slug' => $this->basename,
            'version' => ltrim($release->tag_name, 'v'),
            'author' => $this->plugin_data['Author'],
            'homepage' => $this->plugin_data['PluginURI'],
            'download_link' => $release->zipball_url,
            'sections' => [
                'description' => $this->plugin_data['Description'],
                'changelog' => $release->body ?? 'See GitHub release notes.',
            ],
        ];
    }
}

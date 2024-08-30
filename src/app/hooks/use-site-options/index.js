import { useEffect, useState, useCallback, useRef } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';
import { useDispatch } from '@wordpress/data';
import { store as noticesStore } from '@wordpress/notices';
import { __ } from '@wordpress/i18n';

const useSiteOptions = () => {
  /**
   * Local state.
   */
  const [settings, setSettings] = useState({});
  const [loading, setLoading] = useState(false);
  const [saving, setSaving] = useState(false);

  /**
   * Store handling.
   */
  const { createNotice: cn } = useDispatch(noticesStore);

  /**
   * Helper to create a notice.
   *
   * @param {string} type notice type.
   * @param {string} notice notice message.
   * @returns createNotice instance for the snackbar.
   */
  const createNotice = (type, notice) => cn(
    type,
    notice,
    { type: 'snackbar', isDismissable: true }
  );

  /**
   * Debouncing timer reference.
   */
  const debounceTimer = useRef(null);

  /**
   * Fetch settings initially.
   */
  useEffect(() => {
    (async () => {
      setSettings({});
      setLoading(true);
      try {
        const response = await apiFetch({ path: '/wp/v2/settings' });
        setSettings(response || {});
      } catch ({ message }) {
        createNotice('error', message);
      } finally {
        setLoading(false);
      }
    })();
  }, []);

  /**
   * Debounced settings update function.
   */
  const debouncedSetOptions = useCallback((next) => {
    if (debounceTimer.current) {
      clearTimeout(debounceTimer.current);
    }

    debounceTimer.current = setTimeout(async () => {
      setSaving(true);
      try {
        const newSettings = await apiFetch({ path: '/wp/v2/settings', method: 'POST', data: next });
        setSettings(newSettings);
        createNotice('success', __('Settings Updated', 'wp-gutenberg-site-options'));
      } catch ({ message }) {
        createNotice('error', message);
      } finally {
        setSaving(false);
      }
    }, 500); // Adjust debounce time as needed (e.g., 500ms)
  }, []);

  /**
   * Update settings immediately in local state.
   */
  const setOptions = (next) => {
    setSettings((prevSettings) => ({ ...prevSettings, ...next }));
    debouncedSetOptions(next);
  };

  return [
    {
      loading,
      saving,
      settings,
    },
    setOptions,
  ];
};

export default useSiteOptions;

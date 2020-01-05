<?php

namespace zikwall\m3uparse\epgmodule\epgsources\xmltv;

use zikwall\m3uparse\Debug;
use zikwall\m3uparse\epgmodule\base\EPGParser;
use zikwall\m3uparse\epgmodule\base\IEPGParse;
use zikwall\m3uparse\epgmodule\EPGAgregation;
use zikwall\m3uparse\Timezone;

class XMLTV extends EPGParser implements IEPGParse
{
    public $name = 'xmltv.xml.gz';
    public $xmlName = 'xmltv';

    public function parse(EPGAgregation $EPGAgregation, array $availableChannels) : array
    {
        $this->useLimits($availableChannels);

        $sourceUrl = 'http://www.teleguide.info/download/new3/xmltv.xml.gz';
        $EPGAgregation->downloadEPG($EPGAgregation->getEpgUploadDirectory(), $this->name, $sourceUrl, $this->xmlName);

        $reader = new \XMLReader;
        $reader->open(sprintf('%s/%s.xml', $EPGAgregation->getEpgUploadDirectory(),  $this->xmlName));

        Debug::info(sprintf('Open %s/%s.xml', $EPGAgregation->getEpgUploadDirectory(),  $this->xmlName));

        $epg = [];

        while($reader->read())
        {
            if ($reader->name === 'programme') {
                $id = (int) $reader->getAttribute('channel');

                if ($this->useLimitersByChannels && !in_array($id, $availableChannels)) {
                    // breack not includes EPG
                    continue;
                }

                if ($this->useLocalLimiters && !in_array($id, $this->getLimits())) {
                    continue;
                }

                $start = \DateTime::createFromFormat('YmdHis O', (string) $reader->getAttribute('start'));
                $stop  = \DateTime::createFromFormat('YmdHis O', (string) $reader->getAttribute('stop'));

                $node  = new \SimpleXMLElement($reader->readOuterXML());
                /**
                 * [title] => SimpleXMLElement Object(
                 *      [@attributes] => Array(
                 *          [lang] => ru
                 *      )
                 *      [0] => Title
                 * )
                 */
                $title = (string) $node->title;
                /**
                 * [desc] => SimpleXMLElement Object(
                 *      [@attributes] => Array(
                 *          [lang] => ru
                 *      )
                 *      [0] => Description Text
                 * )
                 */
                $description = (string) $node->desc;

                $epgItem = [
                    'id'                => $id,
                    'start'             => $start->getTimestamp(),
                    'stop'              => $stop->getTimestamp(),
                    'day_begin'         => strtotime(date('d-m-Y', $start->getTimestamp())),
                    'day_begin_human'   => date('d-m-Y', $start->getTimestamp()),
                    'tz'                => Timezone::GMToffsetHours($start->getOffset()),
                    'title'             => $title,
                    'desc'              => $description,
                    'from'              => $this->xmlName,
                ];

                if ($this->useCallback) {
                    $this->callCallback($id, $availableChannels, $epgItem);
                }

                $epg[$id][] = $epgItem;

                /**
                 * If use localname == 'programme' then break outer tags...
                 */
                $reader->next();
                /**
                 * Safe momory
                 */
                unset($node);
                unset($id);
                unset($start);
                unset($stop);
                unset($title);
                unset($description);
            }
        }

        $reader->close();

        return $epg;
    }
}

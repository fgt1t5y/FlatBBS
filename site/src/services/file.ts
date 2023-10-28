import { requester } from './instance';
import { genForm } from '@/utils';
import type {
  UploadForm,
  UploadAs,
  UploadResult,
  RequestResult,
} from '@/types';

export const upload = (files: File[], as: UploadAs | undefined) => {
  const form = genForm<UploadForm>({
    avgfile: files,
    as: as,
  });

  return requester.post<RequestResult<UploadResult>>('/file/upload', form);
};

export const uploadAsAvatar = (avatarFile: File) => {
  return upload([avatarFile], 'avatar');
};
